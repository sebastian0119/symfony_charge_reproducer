<?php

namespace App\Entity;

use App\Repository\InvoiceLineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InvoiceLineRepository::class)]
class InvoiceLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'invoiceLines')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Invoice $invoice = null;

    #[ORM\ManyToOne(inversedBy: 'invoiceLines')]
    private ?Contract $contract = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $productCode = null;

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
    #[Assert\Positive(message: '{{ label }} should be positive')]
    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 5)]
    private ?string $amount = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $taxCode = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $taxCodeRate = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $taxPercentage = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 5, nullable: true)]
    private ?string $taxAmount = null;

    #[ORM\ManyToOne(inversedBy: 'invoiceLines')]
    private ?TaxExemption $taxExemption = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2, nullable: true)]
    private ?string $taxExemptionPercentage = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 5, nullable: true)]
    private ?string $taxExemptionAmount = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $otherCharges = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $otherIdentification = null;

    #[ORM\Column(length: 125, nullable: true)]
    private ?string $otherName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): static
    {
        $this->invoice = $invoice;

        return $this;
    }

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): static
    {
        $this->contract = $contract;

        return $this;
    }

    public function getProductCode(): ?string
    {
        return $this->productCode;
    }

    public function setProductCode(?string $productCode): static
    {
        $this->productCode = $productCode;

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

    public function getTaxCode(): ?int
    {
        return $this->taxCode;
    }

    public function setTaxCode(?int $taxCode): static
    {
        $this->taxCode = $taxCode;

        return $this;
    }

    public function getTaxCodeRate(): ?int
    {
        return $this->taxCodeRate;
    }

    public function setTaxCodeRate(?int $taxCodeRate): static
    {
        $this->taxCodeRate = $taxCodeRate;

        return $this;
    }

    public function getTaxPercentage(): ?string
    {
        return $this->taxPercentage;
    }

    public function setTaxPercentage(?string $taxPercentage): static
    {
        $this->taxPercentage = $taxPercentage;

        return $this;
    }

    public function getTaxAmount(): ?string
    {
        return $this->taxAmount;
    }

    public function setTaxAmount(?string $taxAmount): static
    {
        $this->taxAmount = $taxAmount;

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

    public function getTaxExemptionPercentage(): ?string
    {
        return $this->taxExemptionPercentage;
    }

    public function setTaxExemptionPercentage(?string $taxExemptionPercentage): static
    {
        $this->taxExemptionPercentage = $taxExemptionPercentage;

        return $this;
    }

    public function getTaxExemptionAmount(): ?string
    {
        return $this->taxExemptionAmount;
    }

    public function setTaxExemptionAmount(?string $taxExemptionAmount): static
    {
        $this->taxExemptionAmount = $taxExemptionAmount;

        return $this;
    }

    public function getOtherCharges(): ?int
    {
        return $this->otherCharges;
    }

    public function setOtherCharges(?int $otherCharges): static
    {
        $this->otherCharges = $otherCharges;

        return $this;
    }

    public function getOtherIdentification(): ?string
    {
        return $this->otherIdentification;
    }

    public function setOtherIdentification(?string $otherIdentification): static
    {
        $this->otherIdentification = $otherIdentification;

        return $this;
    }

    public function getOtherName(): ?string
    {
        return $this->otherName;
    }

    public function setOtherName(?string $otherName): static
    {
        $this->otherName = $otherName;

        return $this;
    }
}
