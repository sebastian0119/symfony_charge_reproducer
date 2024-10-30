<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use App\Validator as AppAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $doctype = null;

    #[ORM\Column]
    private ?int $number = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $transmit = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $code = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompanyLegalname $companyLegalname = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompanyLegaltype $companyLegaltype = null;

    #[ORM\Column(length: 25)]
    private ?string $identification = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $salesCondition = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $paymentMethod = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Currency $currency = null;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4)]
    private ?string $exchangerate = null;

    #[Assert\Length(
        min: 5,
        max: 250,
        minMessage: 'The comment must be at least {{ limit }} characters long',
        maxMessage: 'The comment cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(length: 50)]
    private ?string $generatedBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $generatedOn = null;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    #[ORM\JoinColumn(nullable: false)]
    private ?InvoiceStatus $status = null;

    #[Assert\Valid]
    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: InvoiceLine::class, cascade: ['persist'], orphanRemoval: true)]
    #[AppAssert\ExceedsInvoiceable]
    private Collection $invoiceLines;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $treasury = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $relatedDoctype = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $relatedInvoice = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $relatedCode = null;

    public function __construct()
    {
        $this->invoiceLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDoctype(): ?int
    {
        return $this->doctype;
    }

    public function setDoctype(int $doctype): static
    {
        $this->doctype = $doctype;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getTransmit(): ?int
    {
        return $this->transmit;
    }

    public function setTransmit(int $transmit): static
    {
        $this->transmit = $transmit;

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

    public function getCompanyLegalname(): ?CompanyLegalname
    {
        return $this->companyLegalname;
    }

    public function setCompanyLegalname(?CompanyLegalname $companyLegalname): static
    {
        $this->companyLegalname = $companyLegalname;

        return $this;
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

    public function getCompanyLegaltype(): ?CompanyLegaltype
    {
        return $this->companyLegaltype;
    }

    public function setCompanyLegaltype(?CompanyLegaltype $companyLegaltype): static
    {
        $this->companyLegaltype = $companyLegaltype;

        return $this;
    }

    public function getIdentification(): ?string
    {
        return $this->identification;
    }

    public function setIdentification(string $identification): static
    {
        $this->identification = $identification;

        return $this;
    }

    public function getSalesCondition(): ?int
    {
        return $this->salesCondition;
    }

    public function setSalesCondition(int $salesCondition): static
    {
        $this->salesCondition = $salesCondition;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    public function getExchangerate(): ?string
    {
        return $this->exchangerate;
    }

    public function setExchangerate(string $exchangerate): static
    {
        $this->exchangerate = $exchangerate;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getGeneratedBy(): ?string
    {
        return $this->generatedBy;
    }

    public function setGeneratedBy(string $generatedBy): static
    {
        $this->generatedBy = $generatedBy;

        return $this;
    }

    public function getGeneratedOn(): ?\DateTimeInterface
    {
        return $this->generatedOn;
    }

    public function setGeneratedOn(\DateTimeInterface $generatedOn): static
    {
        $this->generatedOn = $generatedOn;

        return $this;
    }

    public function getStatus(): ?InvoiceStatus
    {
        return $this->status;
    }

    public function setStatus(?InvoiceStatus $status): static
    {
        $this->status = $status;

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
            $invoiceLine->setInvoice($this);
        }

        return $this;
    }

    public function removeInvoiceLine(InvoiceLine $invoiceLine): static
    {
        if ($this->invoiceLines->removeElement($invoiceLine)) {
            // set the owning side to null (unless already changed)
            if ($invoiceLine->getInvoice() === $this) {
                $invoiceLine->setInvoice(null);
            }
        }

        return $this;
    }

    public function getTreasury(): ?string
    {
        return $this->treasury;
    }

    public function setTreasury(?string $treasury): static
    {
        $this->treasury = $treasury;

        return $this;
    }

    public function getRelatedDoctype(): ?int
    {
        return $this->relatedDoctype;
    }

    public function setRelatedDoctype(?int $relatedDoctype): static
    {
        $this->relatedDoctype = $relatedDoctype;

        return $this;
    }

    public function getRelatedInvoice(): ?string
    {
        return $this->relatedInvoice;
    }

    public function setRelatedInvoice(?string $relatedInvoice): static
    {
        $this->relatedInvoice = $relatedInvoice;

        return $this;
    }

    public function getRelatedCode(): ?int
    {
        return $this->relatedCode;
    }

    public function setRelatedCode(?int $relatedCode): static
    {
        $this->relatedCode = $relatedCode;

        return $this;
    }
}
