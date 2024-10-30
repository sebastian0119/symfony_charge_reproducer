<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompanyLegalname $companylegal = null;

    #[Assert\Length(
        max: 15,
        maxMessage: 'The code cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 15, nullable: true)]
    private ?string $code = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 20,
        minMessage: 'The phone number must be at least {{ limit }} characters long',
        maxMessage: 'The phone number cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProjectClassification $classification = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProjectScope $scope = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    private ?CrProvince $province = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    private ?CrCanton $canton = null;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    private ?CrDistrict $district = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cadastralmap = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $propertyregister = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2, nullable: true)]
    private ?string $constructionArea = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2, nullable: true)]
    private ?string $constructionCost = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2, nullable: true)]
    private ?string $infrastructureArea = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2, nullable: true)]
    private ?string $infrastructureCost = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProjectStatus $status = null;

    #[ORM\Column]
    private ?bool $publicWork = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Contract::class)]
    private Collection $contracts;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Invoice::class)]
    private Collection $invoices;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: Charge::class)]
    private Collection $charges;

    #[ORM\OneToMany(mappedBy: 'project', targetEntity: TrackerProject::class)]
    private Collection $trackerProjects;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deliveryStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deliveryEnd = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne]
    private ?ContractDepartment $deliveryStage = null;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
        $this->invoices = new ArrayCollection();
        $this->charges = new ArrayCollection();
        $this->trackerProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCompanylegal(): ?CompanyLegalname
    {
        return $this->companylegal;
    }

    public function setCompanylegal(?CompanyLegalname $companylegal): static
    {
        $this->companylegal = $companylegal;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getClassification(): ?ProjectClassification
    {
        return $this->classification;
    }

    public function setClassification(?ProjectClassification $classification): static
    {
        $this->classification = $classification;

        return $this;
    }

    public function getScope(): ?ProjectScope
    {
        return $this->scope;
    }

    public function setScope(?ProjectScope $scope): static
    {
        $this->scope = $scope;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getProvince(): ?CrProvince
    {
        return $this->province;
    }

    public function setProvince(?CrProvince $province): static
    {
        $this->province = $province;

        return $this;
    }

    public function getCanton(): ?CrCanton
    {
        return $this->canton;
    }

    public function setCanton(?CrCanton $canton): static
    {
        $this->canton = $canton;

        return $this;
    }

    public function getDistrict(): ?CrDistrict
    {
        return $this->district;
    }

    public function setDistrict(?CrDistrict $district): static
    {
        $this->district = $district;

        return $this;
    }

    public function getCadastralmap(): ?string
    {
        return $this->cadastralmap;
    }

    public function setCadastralmap(?string $cadastralmap): static
    {
        $this->cadastralmap = $cadastralmap;

        return $this;
    }

    public function getPropertyregister(): ?string
    {
        return $this->propertyregister;
    }

    public function setPropertyregister(?string $propertyregister): static
    {
        $this->propertyregister = $propertyregister;

        return $this;
    }

    public function getConstructionArea(): ?string
    {
        return $this->constructionArea;
    }

    public function setConstructionArea(string $constructionArea): static
    {
        $this->constructionArea = $constructionArea;

        return $this;
    }

    public function getConstructionCost(): ?string
    {
        return $this->constructionCost;
    }

    public function setConstructionCost(string $constructionCost): static
    {
        $this->constructionCost = $constructionCost;

        return $this;
    }

    public function getInfrastructureCost(): ?string
    {
        return $this->infrastructureCost;
    }

    public function setInfrastructureCost(string $infrastructureCost): static
    {
        $this->infrastructureCost = $infrastructureCost;

        return $this;
    }

    public function getInfrastructureArea(): ?string
    {
        return $this->infrastructureArea;
    }

    public function setInfrastructureArea(string $infrastructureArea): static
    {
        $this->infrastructureArea = $infrastructureArea;

        return $this;
    }

    public function getStatus(): ?ProjectStatus
    {
        return $this->status;
    }

    public function setStatus(?ProjectStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPublicWork(): ?bool
    {
        return $this->publicWork;
    }

    public function setPublicWork(bool $publicWork): static
    {
        $this->publicWork = $publicWork;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection<int, Contract>
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(Contract $contract): static
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts->add($contract);
            $contract->setProject($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): static
    {
        if ($this->contracts->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getProject() === $this) {
                $contract->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): static
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
            $invoice->setProject($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getProject() === $this) {
                $invoice->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Charge>
     */
    public function getCharges(): Collection
    {
        return $this->charges;
    }

    public function addCharge(Charge $charge): static
    {
        if (!$this->charges->contains($charge)) {
            $this->charges->add($charge);
            $charge->setProject($this);
        }

        return $this;
    }

    public function removeCharge(Charge $charge): static
    {
        if ($this->charges->removeElement($charge)) {
            // set the owning side to null (unless already changed)
            if ($charge->getProject() === $this) {
                $charge->setProject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TrackerProject>
     */
    public function getTrackerProjects(): Collection
    {
        return $this->trackerProjects;
    }

    public function addTrackerProject(TrackerProject $trackerProject): static
    {
        if (!$this->trackerProjects->contains($trackerProject)) {
            $this->trackerProjects->add($trackerProject);
            $trackerProject->setProject($this);
        }

        return $this;
    }

    public function removeTrackerProject(TrackerProject $trackerProject): static
    {
        if ($this->trackerProjects->removeElement($trackerProject)) {
            // set the owning side to null (unless already changed)
            if ($trackerProject->getProject() === $this) {
                $trackerProject->setProject(null);
            }
        }

        return $this;
    }

    public function getDeliveryStart(): ?\DateTimeInterface
    {
        return $this->deliveryStart;
    }

    public function setDeliveryStart(?\DateTimeInterface $deliveryStart): static
    {
        $this->deliveryStart = $deliveryStart;

        return $this;
    }

    public function getDeliveryEnd(): ?\DateTimeInterface
    {
        return $this->deliveryEnd;
    }

    public function setDeliveryEnd(?\DateTimeInterface $deliveryEnd): static
    {
        $this->deliveryEnd = $deliveryEnd;

        return $this;
    }

    public function getDeliveryStage(): ?ContractDepartment
    {
        return $this->deliveryStage;
    }

    public function setDeliveryStage(?ContractDepartment $deliveryStage): static
    {
        $this->deliveryStage = $deliveryStage;

        return $this;
    }
}
