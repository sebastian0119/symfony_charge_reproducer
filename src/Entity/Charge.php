<?php

namespace App\Entity;

use App\Repository\ChargeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ChargeRepository::class)]
class Charge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $messageDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $messageNumber = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $messageCode = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $transmit = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne(inversedBy: 'charges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompanyLegaltype $companyLegaltype = null;

    #[Assert\Positive]
    #[ORM\Column(length: 25)]
    private ?string $companyIdentification = null;

    #[Assert\Positive]
    #[ORM\Column(length: 8)]
    private ?string $companyActivity = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne(inversedBy: 'charges')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Project $project = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne(inversedBy: 'charges')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Subcontract $subcontract = null;

    #[Assert\Date]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $reply = null;

    #[ORM\ManyToOne(inversedBy: 'charges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ChargeStatus $status = null;

    #[Assert\Positive]
    #[ORM\Column(length: 10)]
    private ?string $number = null;

    #[ORM\Column(length: 50)]
    private ?string $code = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne(inversedBy: 'charges')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Currency $currency = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $factor = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $related = null;

    #[Assert\PositiveOrZero]
    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 5, nullable: true)]
    private ?string $taxAmount = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $taxCondition = null;

    #[Assert\PositiveOrZero]
    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 5, nullable: true)]
    private ?string $taxCredit = null;

    #[Assert\PositiveOrZero]
    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 5, nullable: true)]
    private ?string $taxExpense = null;

    #[Assert\PositiveOrZero]
    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 5)]
    private ?string $amount = null;

    #[ORM\Column(length: 80, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $treasury = null;

    #[ORM\Column(length: 50)]
    private ?string $registeredBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $registeredOn = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessageDate(): ?\DateTimeInterface
    {
        return $this->messageDate;
    }

    public function setMessageDate(?\DateTimeInterface $messageDate): static
    {
        $this->messageDate = $messageDate;

        return $this;
    }

    public function getMessageNumber(): ?int
    {
        return $this->messageNumber;
    }

    public function setMessageNumber(?int $messageNumber): static
    {
        $this->messageNumber = $messageNumber;

        return $this;
    }

    public function getMessageCode(): ?string
    {
        return $this->messageCode;
    }

    public function setMessageCode(?string $messageCode): static
    {
        $this->messageCode = $messageCode;

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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

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

    public function getCompanyIdentification(): ?string
    {
        return $this->companyIdentification;
    }

    public function setCompanyIdentification(string $companyIdentification): static
    {
        $this->companyIdentification = $companyIdentification;

        return $this;
    }

    public function getCompanyActivity(): ?string
    {
        return $this->companyActivity;
    }

    public function setCompanyActivity(string $companyActivity): static
    {
        $this->companyActivity = $companyActivity;

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

    public function getSubcontract(): ?Subcontract
    {
        return $this->subcontract;
    }

    public function setSubcontract(?Subcontract $subcontract): static
    {
        $this->subcontract = $subcontract;

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

    public function getReply(): ?int
    {
        return $this->reply;
    }

    public function setReply(int $reply): static
    {
        $this->reply = $reply;

        return $this;
    }

    public function getStatus(): ?ChargeStatus
    {
        return $this->status;
    }

    public function setStatus(?ChargeStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

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

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getFactor(): ?int
    {
        return $this->factor;
    }

    public function setFactor(int $factor): static
    {
        $this->factor = $factor;

        return $this;
    }

    public function getRelated(): ?string
    {
        return $this->related;
    }

    public function setRelated(?string $related): static
    {
        $this->related = $related;

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

    public function getTaxCondition(): ?int
    {
        return $this->taxCondition;
    }

    public function setTaxCondition(?int $taxCondition): static
    {
        $this->taxCondition = $taxCondition;

        return $this;
    }

    public function getTaxCredit(): ?string
    {
        return $this->taxCredit;
    }

    public function setTaxCredit(?string $taxCredit): static
    {
        $this->taxCredit = $taxCredit;

        return $this;
    }

    public function getTaxExpense(): ?string
    {
        return $this->taxExpense;
    }

    public function setTaxExpense(string $taxExpense): static
    {
        $this->taxExpense = $taxExpense;

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

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

    public function getRegisteredBy(): ?string
    {
        return $this->registeredBy;
    }

    public function setRegisteredBy(string $registeredBy): static
    {
        $this->registeredBy = $registeredBy;

        return $this;
    }

    public function getRegisteredOn(): ?\DateTimeInterface
    {
        return $this->registeredOn;
    }

    public function setRegisteredOn(\DateTimeInterface $registeredOn): static
    {
        $this->registeredOn = $registeredOn;

        return $this;
    }
}
