<?php

namespace App\Controller;

use App\Entity\Charge;
use App\Form\ChargeType;
use App\Repository\ChargeRepository;
use App\Repository\ChargeStatusRepository;
use App\Repository\CompanyLegaltypeRepository;
use App\Repository\CurrencyRepository;
use App\Repository\ProjectRepository;
use App\Repository\SubcontractRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormError;
// use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;

#[Route('/charge')]
class ChargeController extends AbstractController
{
    #[Route('/', name: 'app_charge_index', methods: ['GET'])]
    public function index(ChargeRepository $chargeRepository, PaginatorInterface $paginator, Request $request): Response
    {
        // get current page of paginator
        $paramPage = $request->query->getInt('page', 1);
        $paramSearchString = $request->query->getAlnum('searchString');
        $paramSearchStatus = $request->query->getInt('searchStatus');
        $query = $chargeRepository->paginateCharges($paramSearchString, $paramSearchStatus, $paramPage); // do query from repository (returns query)

        // hand query over to paginator
        $charges = $paginator->paginate(
            // Doctrine query, not the results
            $query,
            // Define the page parameter
            $paramPage,
            // Items per page
            15
        );

        if ($request->isXmlHttpRequest()) {
            $renderTwig = 'charge/_table.html.twig';
        } else {
            $renderTwig = 'charge/index.html.twig';
        }

        return $this->render($renderTwig, [
            'charges' => $charges,
        ]);

        /*
        return $this->render('charge/index.html.twig', [
            'charges' => $chargeRepository->findAll(),
        ]);
        */
    }

    #[Route('/new', name: 'app_charge_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ChargeStatusRepository $chargeStatusRepository, CurrencyRepository $currencyRepository, CompanyLegaltypeRepository $companyLegaltypeRepository,
    #[Autowire('%kernel.project_dir%/public/uploads/charge')] string $chargeDirectory): Response
    {
        $charge = new Charge();

        // Information required for following operations:
        // Get path of uploaded xml file (see route 'import') from session flashbag for some defaults
        $flashbag = $request->getSession()->getFlashBag();
        $xmlDefaults = null;
        // TODO: check if session attribute and file exist
        if ($xmlFile = $flashbag->get('xmlTemp')) {
            $xmlPath = $chargeDirectory . '/' . $xmlFile[0];
            if (file_exists($xmlPath)) {
                // try to load xml file into JSON
                $xmlContent = simplexml_load_file($xmlPath);
                $xmlDefaults = json_decode(json_encode($xmlContent));
                // delete file
                unlink($xmlPath);
            }
        }

        // Defaults for properties that are NOT displayed in the form:
        $charge->setStatus($chargeStatusRepository->find(1));
        $charge->setMessageDate(null);
        $charge->setMessageNumber(null);
        $charge->setMessageCode(null);
        $charge->setTransmit('0');
        $charge->setFactor('1');
        $charge->setRelated(null);
        $charge->setTreasury('');
        // TODO: should be current user
        $charge->setRegisteredBy('sklus');
        $charge->setRegisteredOn(new \DateTime());

        // Defaults for properties that ARE displayed in the form:
        if(isset($xmlDefaults->ResumenFactura->CodigoTipoMoneda->CodigoMoneda)) {
            $charge->setCurrency($currencyRepository->findOneBy(['short' => $xmlDefaults->ResumenFactura->CodigoTipoMoneda->CodigoMoneda]));
        }
        if(isset($xmlDefaults->Emisor->Identificacion->Tipo)) {
            $charge->setCompanyLegaltype($companyLegaltypeRepository->find($xmlDefaults->Emisor->Identificacion->Tipo));
        }
        if(isset($xmlDefaults->Emisor->Identificacion->Numero)) {
            $charge->setCompanyIdentification($xmlDefaults->Emisor->Identificacion->Numero);
        }
        if(isset($xmlDefaults->CodigoActividad)) {
            $charge->setCompanyActivity($xmlDefaults->CodigoActividad);
        }
        if(isset($xmlDefaults->FechaEmision)) {
            $charge->setDate(new \DateTime('@' . strtotime($xmlDefaults->FechaEmision)));
        }
        if(isset($xmlDefaults->Clave)) {
            $chargenumber = substr($xmlDefaults->Clave, 31, 10);
            $chargenumber = ltrim($chargenumber, '0');
            $charge->setNumber($chargenumber);
            $charge->setCode($xmlDefaults->Clave);
        }
        if(isset($xmlDefaults->ResumenFactura->TotalImpuesto)) {
            $charge->setTaxAmount($xmlDefaults->ResumenFactura->TotalImpuesto);
        }
        if(isset($xmlDefaults->ResumenFactura->TotalComprobante)) {
            $charge->setAmount($xmlDefaults->ResumenFactura->TotalComprobante);
        }
        
        $form = $this->createForm(ChargeType::class, $charge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $entityManager->persist($charge);
            $entityManager->flush();

            return $this->redirectToRoute('charge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('charge/new.html.twig', [
            'charge' => $charge,
            'form' => $form,
        ]);
    }

    #[Route('/import', name: 'app_charge_import', methods: ['GET', 'POST'])]
    public function import(Request $request, Security $security,
        #[Autowire('%kernel.project_dir%/public/uploads/charge')] string $chargeDirectory): Response
    {
        // create an independent and unmapped form (just with upload button)
        $defaultData = ['message' => 'Upload an XML file'];
        $form = $this->createFormBuilder($defaultData)
            ->add('xml', FileType::class, [
                'label' => 'Select XML file...',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'text/xml',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid XML file',
                    ])
                ],
            ])
            ->getForm();
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // get file object from submitted form
            $xmlFile = $form->get('xml')->getData();
            $originalFilename = pathinfo($xmlFile->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $newFilename = 'temp-' . uniqid() . '.' . $xmlFile->guessExtension();
            // save file name to session (flash = gets deleted, once retrieved), so that it can be picked up from route 'new'
            $this->addFlash('xmlTemp', $newFilename);
            
            // Move the file to the upload directory
            try {
                $xmlFile->move($chargeDirectory, $newFilename);
            } catch (\Throwable $th) {
                // TODO: check if this can be made a little 'nicer' / more efficient; applies for TaxExemptionController, too
                if ($security->isGranted('ROLE_ADMIN')) {
                    $error = new FormError($th->getMessage());
                } else {
                    $error = new FormError('An error occurred while uploading the file. Please contact your administrator.');
                }
                $form->addError($error);
                return $this->render('charge/import.html.twig', [
                    'form' => $form,
                ]);
            }
            
            return $this->redirectToRoute('app_charge_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('charge/import.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/ajax/projects', name:'app_charge_ajaxProjects', methods:['GET'])]
    public function ajaxProjects(ProjectRepository $ProjectRepository, Request $request): Response
    {
        $paramCompany = $request->query->getInt('company');

        return $this->render('components/ajax_options.html.twig', [
            'options' => $ProjectRepository->findProjectSubcontractsByCompany(
                ['company' => $paramCompany],
            ),
            'preselected' => $paramCompany,
        ]);
    }

    #[Route('/ajax/subcontracts', name:'app_charge_ajaxSubcontracts', methods:['GET'])]
    public function ajaxSubcontracts(SubcontractRepository $SubcontractRepository, Request $request): Response
    {
        $paramProject = $request->query->getInt('project');
        $paramCompany = $request->query->getInt('company');

        return $this->render('charge/ajax_subcontracts.html.twig', [
            'options' => $SubcontractRepository->findCompanySubcontractsByProject(
                ['project' => $paramProject],
                ['company' => $paramCompany],
            ),
            'preselected' => $paramProject,
        ]);
    }

    #[Route('/{id}', name: 'app_charge_show', methods: ['GET'])]
    public function show(Charge $charge): Response
    {
        return $this->render('charge/show.html.twig', [
            'charge' => $charge,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_charge_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Charge $charge, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ChargeType::class, $charge);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_charge_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('charge/edit.html.twig', [
            'charge' => $charge,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_charge_delete', methods: ['POST'])]
    public function delete(Request $request, Charge $charge, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$charge->getId(), $request->request->get('_token'))) {
            $entityManager->remove($charge);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_charge_index', [], Response::HTTP_SEE_OTHER);
    }
}
