<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 3,
        max: 150,
        minMessage: 'The company name must be at least {{ limit }} characters long',
        maxMessage: 'The company name cannot be longer than {{ limit }} characters',
    )]
    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\Length(
        min: 3,
        max: 150,
        minMessage: 'The alternate name must be at least {{ limit }} characters long',
        maxMessage: 'The alternate name cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $alternate = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[Assert\Length(
        min: 3,
        max: 20,
        minMessage: 'The phone number must be at least {{ limit }} characters long',
        maxMessage: 'The phone number cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone01 = null;

    #[Assert\Length(
        min: 3,
        max: 20,
        minMessage: 'The phone number must be at least {{ limit }} characters long',
        maxMessage: 'The phone number cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone02 = null;

    #[Assert\Length(
        min: 3,
        max: 20,
        minMessage: 'The phone number must be at least {{ limit }} characters long',
        maxMessage: 'The phone number cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fax = null;

    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne(inversedBy: 'companies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    #[ORM\ManyToOne(inversedBy: 'companies')]
    private ?CrProvince $province = null;

    #[ORM\ManyToOne(inversedBy: 'companies')]
    private ?CrCanton $canton = null;

    #[ORM\ManyToOne(inversedBy: 'companies')]
    private ?CrDistrict $district = null;

    #[Assert\Length(
        min: 5,
        max: 250,
        minMessage: 'The address must be at least {{ limit }} characters long',
        maxMessage: 'The address cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[ORM\Column]
    private ?int $creditDays = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $paymentMethod = null;

    #[Assert\Length(
        min: 3,
        max: 250,
        minMessage: 'The comment must be at least {{ limit }} characters long',
        maxMessage: 'The comment cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accountingComments = null;

    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $accountingMail = null;

    #[Assert\NotBlank]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $vatCondition = 8;

    #[Assert\Length(
        min: 3,
        max: 250,
        minMessage: 'The comment must be at least {{ limit }} characters long',
        maxMessage: 'The comment cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comments = null;

    #[Assert\NotBlank(message: 'Please select at least one option')]
    #[ORM\Column]
    private ?array $classification = null;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: CompanyLegalname::class, orphanRemoval: true)]
    private Collection $companyLegalnames;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Project::class)]
    private Collection $projects;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Subcontract::class)]
    private Collection $subcontracts;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Charge::class)]
    private Collection $charges;

    public function __construct()
    {
        $this->companyLegalnames = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->subcontracts = new ArrayCollection();
        $this->charges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAlternate(): ?string
    {
        return $this->alternate;
    }

    public function setAlternate(?string $alternate): static
    {
        $this->alternate = $alternate;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getPhone01(): ?string
    {
        return $this->phone01;
    }

    public function setPhone01(?string $phone01): static
    {
        $this->phone01 = $phone01;

        return $this;
    }

    public function getPhone02(): ?string
    {
        return $this->phone02;
    }

    public function setPhone02(?string $phone02): static
    {
        $this->phone02 = $phone02;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): static
    {
        $this->fax = $fax;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCreditDays(): ?int
    {
        return $this->creditDays;
    }

    public function setCreditDays(int $creditDays): static
    {
        $this->creditDays = $creditDays;

        return $this;
    }

    public function getPaymentMethod(): ?int
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(int $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function getAccountingComments(): ?string
    {
        return $this->accountingComments;
    }

    public function setAccountingComments(?string $accountingComments): static
    {
        $this->accountingComments = $accountingComments;

        return $this;
    }

    public function getAccountingMail(): ?string
    {
        return $this->accountingMail;
    }

    public function setAccountingMail(?string $accountingMail): static
    {
        $this->accountingMail = $accountingMail;

        return $this;
    }

    public function getVatCondition(): ?int
    {
        return $this->vatCondition;
    }

    public function setVatCondition(int $vatCondition): static
    {
        $this->vatCondition = $vatCondition;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): static
    {
        $this->comments = $comments;

        return $this;
    }

    public function getClassification(): ?array
    {
        return $this->classification;
    }

    public function setClassification(?array $classification): static
    {
        $this->classification = $classification;

        return $this;
    }

    /**
     * @return Collection|CompanyLegalname[]
     */
    public function getCompanyLegalnames(): Collection
    {
        return $this->companyLegalnames;
    }

    public function addCompanyLegalname(CompanyLegalname $companyLegalname): static
    {
        if (!$this->companyLegalnames->contains($companyLegalname)) {
            $this->companyLegalnames[] = $companyLegalname;
            $companyLegalname->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyLegalname(CompanyLegalname $companyLegalname): static
    {
        if ($this->companyLegalnames->contains($companyLegalname)) {
            $this->companyLegalnames->removeElement($companyLegalname);
            // set the owning side to null (unless already changed)
            if ($companyLegalname->getCompany() === $this) {
                $companyLegalname->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setCompany($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getCompany() === $this) {
                $project->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Subcontract>
     */
    public function getSubcontracts(): Collection
    {
        return $this->subcontracts;
    }

    public function addSubcontract(Subcontract $subcontract): static
    {
        if (!$this->subcontracts->contains($subcontract)) {
            $this->subcontracts->add($subcontract);
            $subcontract->setCompany($this);
        }

        return $this;
    }

    public function removeSubcontract(Subcontract $subcontract): static
    {
        if ($this->subcontracts->removeElement($subcontract)) {
            // set the owning side to null (unless already changed)
            if ($subcontract->getCompany() === $this) {
                $subcontract->setCompany(null);
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
            $charge->setCompany($this);
        }

        return $this;
    }

    public function removeCharge(Charge $charge): static
    {
        if ($this->charges->removeElement($charge)) {
            // set the owning side to null (unless already changed)
            if ($charge->getCompany() === $this) {
                $charge->setCompany(null);
            }
        }

        return $this;
    }
}
