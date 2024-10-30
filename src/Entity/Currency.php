<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
class Currency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $name = null;

    #[ORM\Column(length: 5)]
    private ?string $short = null;

    #[ORM\Column(length: 10)]
    private ?string $symbol = null;

    #[ORM\OneToMany(mappedBy: 'currency', targetEntity: Contract::class)]
    private Collection $contracts;

    #[ORM\OneToMany(mappedBy: 'currency', targetEntity: Invoice::class)]
    private Collection $invoices;

    #[ORM\OneToMany(mappedBy: 'currency', targetEntity: Subcontract::class)]
    private Collection $subcontracts;

    #[ORM\OneToMany(mappedBy: 'currency', targetEntity: Charge::class)]
    private Collection $charges;

    #[ORM\OneToMany(mappedBy: 'currency', targetEntity: TrackerExpense::class)]
    private Collection $trackerExpenses;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
        $this->invoices = new ArrayCollection();
        $this->subcontracts = new ArrayCollection();
        $this->charges = new ArrayCollection();
        $this->trackerExpenses = new ArrayCollection();
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

    public function getShort(): ?string
    {
        return $this->short;
    }

    public function setShort(string $short): static
    {
        $this->short = $short;

        return $this;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): static
    {
        $this->symbol = $symbol;

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
            $contract->setCurrency($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): static
    {
        if ($this->contracts->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getCurrency() === $this) {
                $contract->setCurrency(null);
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
            $invoice->setCurrency($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getCurrency() === $this) {
                $invoice->setCurrency(null);
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
            $subcontract->setCurrency($this);
        }

        return $this;
    }

    public function removeSubcontract(Subcontract $subcontract): static
    {
        if ($this->subcontracts->removeElement($subcontract)) {
            // set the owning side to null (unless already changed)
            if ($subcontract->getCurrency() === $this) {
                $subcontract->setCurrency(null);
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
            $charge->setCurrency($this);
        }

        return $this;
    }

    public function removeCharge(Charge $charge): static
    {
        if ($this->charges->removeElement($charge)) {
            // set the owning side to null (unless already changed)
            if ($charge->getCurrency() === $this) {
                $charge->setCurrency(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TrackerExpenses>
     */
    public function getTrackerExpenses(): Collection
    {
        return $this->trackerExpenses;
    }

    public function addTrackerExpense(TrackerExpenses $trackerExpense): static
    {
        if (!$this->trackerExpenses->contains($trackerExpense)) {
            $this->trackerExpenses->add($trackerExpense);
            $trackerExpense->setCurrency($this);
        }

        return $this;
    }

    public function removeTrackerExpense(TrackerExpenses $trackerExpense): static
    {
        if ($this->trackerExpenses->removeElement($trackerExpense)) {
            // set the owning side to null (unless already changed)
            if ($trackerExpense->getCurrency() === $this) {
                $trackerExpense->setCurrency(null);
            }
        }

        return $this;
    }
}
