<?php

namespace App\Entity;

use App\Repository\CrCantonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CrCantonRepository::class)]
class CrCanton
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'crCantons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CrProvince $province = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'canton', targetEntity: CrDistrict::class)]
    private Collection $crDistricts;

    #[ORM\OneToMany(mappedBy: 'canton', targetEntity: Project::class)]
    private Collection $projects;

    #[ORM\OneToMany(mappedBy: 'canton', targetEntity: Company::class)]
    private Collection $companies;

    public function __construct()
    {
        $this->crDistricts = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->companies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, CrDistrict>
     */
    public function getCrDistricts(): Collection
    {
        return $this->crDistricts;
    }

    public function addCrDistrict(CrDistrict $crDistrict): static
    {
        if (!$this->crDistricts->contains($crDistrict)) {
            $this->crDistricts->add($crDistrict);
            $crDistrict->setCanton($this);
        }

        return $this;
    }

    public function removeCrDistrict(CrDistrict $crDistrict): static
    {
        if ($this->crDistricts->contains($crDistrict)) {
            $this->crDistricts->removeElement($crDistrict);
            // set the owning side to null (unless already changed)
            if ($crDistrict->getCanton() === $this) {
                $crDistrict->setCanton(null);
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
            $project->setCanton($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->contains($project)) {
            $this->projects->removeElement($project);
            // set the owning side to null (unless already changed)
            if ($project->getCanton() === $this) {
                $project->setCanton(null);
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
            $company->setCanton($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): static
    {
        if ($this->companies->contains($company)) {
            $this->companies->removeElement($company);
            // set the owning side to null (unless already changed)
            if ($company->getCanton() === $this) {
                $company->setCanton(null);
            }
        }

        return $this;
    }
}
