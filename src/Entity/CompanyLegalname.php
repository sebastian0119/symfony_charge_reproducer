<?php

namespace App\Entity;

use App\Repository\CompanyLegalnameRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CompanyLegalnameRepository::class)]
class CompanyLegalname
{
    // TODO: I believe there is some error in the relationship between Companies and CompanyLegalnames
    // At least ../company/legalnames (which should list an index) causes an error
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'companyLegalnames')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 250,
        minMessage: 'The comment must be at least {{ limit }} characters long',
        maxMessage: 'The comment cannot be longer than {{ limit }} characters',
    )]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\NotBlank(message: 'Please select one option')]
    #[ORM\ManyToOne(inversedBy: 'companyLegalnames')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompanyLegaltype $type = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 50)]
    private ?string $identification = null;

    #[ORM\OneToMany(mappedBy: 'companyLegalname', targetEntity: Invoice::class)]
    private Collection $invoices;

    #[ORM\OneToMany(mappedBy: 'companylegal', targetEntity: Project::class)]
    private Collection $projects;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
        $this->projects = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?CompanyLegaltype
    {
        return $this->type;
    }

    public function setType(?CompanyLegaltype $type): static
    {
        $this->type = $type;

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
            $invoice->setCompanylegal($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getCompanylegal() === $this) {
                $invoice->setCompanylegal(null);
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
            $project->setCompanylegal($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getCompanylegal() === $this) {
                $invoice->setCompanylegal(null);
            }
        }

        return $this;
    }
}
