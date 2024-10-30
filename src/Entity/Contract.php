<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ContractDepartment $department = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        max: 250,
        minMessage: 'The description must be at least {{ limit }} characters long',
        maxMessage: 'The description cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2)]
    private ?string $amount = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tax $tax = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    private ?TaxExemption $taxExemption = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ContractStatus $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $hoursArchitect = null;

    #[ORM\Column(nullable: true)]
    private ?int $hoursModelling = null;

    #[ORM\Column(nullable: true)]
    private ?int $hoursIntern = null;

    #[ORM\ManyToOne(inversedBy: 'contracts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Currency $currency = null;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: InvoiceLine::class)]
    private Collection $invoiceLines;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: Subcontract::class)]
    private Collection $subcontracts;

    #[ORM\OneToMany(mappedBy: 'contract', targetEntity: TrackerProject::class)]
    private Collection $trackerProjects;

    public function __construct()
    {
        $this->invoiceLines = new ArrayCollection();
        $this->subcontracts = new ArrayCollection();
        $this->trackerProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    public function getDepartment(): ?ContractDepartment
    {
        return $this->department;
    }

    public function setDepartment(?ContractDepartment $department): static
    {
        $this->department = $department;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getTax(): ?Tax
    {
        return $this->tax;
    }

    public function setTax(?Tax $tax): static
    {
        $this->tax = $tax;

        return $this;
    }

    public function getTaxExemption(): ?TaxExemption
    {
        return $this->taxExemption;
    }

    public function setTaxExemption(?TaxExemption $taxExemption): static
    {
        $this->taxExemption = $taxExemption;

        return $this;
    }

    public function getStatus(): ?ContractStatus
    {
        return $this->status;
    }

    public function setStatus(?ContractStatus $status): static
    {
        $this->status = $status;

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

    public function getHoursArchitect(): ?int
    {
        return $this->hoursArchitect;
    }

    public function setHoursArchitect(?int $hoursArchitect): static
    {
        $this->hoursArchitect = $hoursArchitect;

        return $this;
    }

    public function getHoursModelling(): ?int
    {
        return $this->hoursModelling;
    }

    public function setHoursModelling(?int $hoursModelling): static
    {
        $this->hoursModelling = $hoursModelling;

        return $this;
    }

    public function getHoursIntern(): ?int
    {
        return $this->hoursIntern;
    }

    public function setHoursIntern(?int $hoursIntern): static
    {
        $this->hoursIntern = $hoursIntern;

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return Collection<int, InvoiceLine>
     */
    public function getInvoiceLines(): Collection
    {
        return $this->invoiceLines;
    }

    public function addInvoiceLine(InvoiceLine $invoiceLine): static
    {
        if (!$this->invoiceLines->contains($invoiceLine)) {
            $this->invoiceLines->add($invoiceLine);
            $invoiceLine->setContract($this);
        }

        return $this;
    }

    public function removeInvoiceLine(InvoiceLine $invoiceLine): static
    {
        if ($this->invoiceLines->removeElement($invoiceLine)) {
            // set the owning side to null (unless already changed)
            if ($invoiceLine->getContract() === $this) {
                $invoiceLine->setContract(null);
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
            $subcontract->setContract($this);
        }

        return $this;
    }

    public function removeSubcontract(Subcontract $subcontract): static
    {
        if ($this->subcontracts->removeElement($subcontract)) {
            // set the owning side to null (unless already changed)
            if ($subcontract->getContract() === $this) {
                $subcontract->setContract(null);
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
            $trackerProject->setContract($this);
        }

        return $this;
    }

    public function removeTrackerProject(TrackerProject $trackerProject): static
    {
        if ($this->trackerProjects->removeElement($trackerProject)) {
            // set the owning side to null (unless already changed)
            if ($trackerProject->getContract() === $this) {
                $trackerProject->setContract(null);
            }
        }

        return $this;
    }
}
