<?php

namespace App\Entity;

use App\Repository\CompanyLegaltypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyLegaltypeRepository::class)]
class CompanyLegaltype
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $short = null;

    #[ORM\Column(length: 100)]
    private ?string $full = null;

    #[ORM\OneToMany(mappedBy: 'companyLegaltype', targetEntity: Invoice::class)]
    private Collection $invoices;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: CompanyLegalname::class)]
    private Collection $companyLegalnames;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->companyLegalnames = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFull(): ?string
    {
        return $this->full;
    }

    public function setFull(string $full): static
    {
        $this->full = $full;

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
            $invoice->setCompanyLegaltype($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getCompanyLegaltype() === $this) {
                $invoice->setCompanyLegaltype(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompanyLegalname>
     */
    public function getCompanyLegalnames(): Collection
    {
        return $this->companyLegalnames;
    }

    public function addCompanyLegalname(CompanyLegalname $companyLegalname): static
    {
        if (!$this->companyLegalnames->contains($companyLegalname)) {
            $this->companyLegalnames->add($companyLegalname);
            $companyLegalname->setCompanyLegaltype($this);
        }

        return $this;
    }

    public function removeCompanyLegalname(CompanyLegalname $companyLegalname): static
    {
        if ($this->companyLegalnames->removeElement($companyLegalname)) {
            // set the owning side to null (unless already changed)
            if ($companyLegalname->getCompanyLegaltype() === $this) {
                $companyLegalname->setCompanyLegaltype(null);
            }
        }

        return $this;
    }
}
