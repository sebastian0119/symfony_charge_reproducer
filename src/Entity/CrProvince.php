<?php

namespace App\Entity;

use App\Repository\CrProvinceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CrProvinceRepository::class)]
class CrProvince
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'province', targetEntity: CrCanton::class)]
    private Collection $crCantons;

    #[ORM\OneToMany(mappedBy: 'province', targetEntity: Project::class)]
    private Collection $projects;

    #[ORM\OneToMany(mappedBy: 'province', targetEntity: Company::class)]
    private Collection $companies;

    public function __construct()
    {
        $this->crCantons = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->companies = new ArrayCollection();
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

    /**
     * @return Collection<int, CrCanton>
     */
    public function getCrCantons(): Collection
    {
        return $this->crCantons;
    }

    public function addCrCanton(CrCanton $crCanton): static
    {
        if (!$this->crCantons->contains($crCanton)) {
            $this->crCantons->add($crCanton);
            $crCanton->setProvince($this);
        }

        return $this;
    }

    public function removeCrCanton(CrCanton $crCanton): static
    {
        if ($this->crCantons->contains($crCanton)) {
            $this->crCantons->removeElement($crCanton);
            // set the owning side to null (unless already changed)
            if ($crCanton->getProvince() === $this) {
                $crCanton->setProvince(null);
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
            $project->setProvince($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getProvince() === $this) {
                $project->setProvince(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Company>
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): static
    {
        if (!$this->companies->contains($company)) {
            $this->companies->add($company);
            $company->setProvince($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): static
    {
        if ($this->companies->contains($company)) {
            $this->companies->removeElement($company);
            // set the owning side to null (unless already changed)
            if ($company->getProvince() === $this) {
                $company->setProvince(null);
            }
        }

        return $this;
    }
}
