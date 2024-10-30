<?php

namespace App\Entity;

use App\Repository\ContractDepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractDepartmentRepository::class)]
class ContractDepartment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Contract::class)]
    private Collection $contracts;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: TrackerProject::class)]
    private Collection $trackerProjects;

    public function __construct()
    {
        $this->contracts = new ArrayCollection();
        $this->trackerProjects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $contract->setDepartment($this);
        }

        return $this;
    }

    public function removeContract(Contract $contract): static
    {
        if ($this->contracts->removeElement($contract)) {
            // set the owning side to null (unless already changed)
            if ($contract->getDepartment() === $this) {
                $contract->setDepartment(null);
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
            $trackerProject->setDepartment($this);
        }

        return $this;
    }

    public function removeTrackerProject(TrackerProject $trackerProject): static
    {
        if ($this->trackerProjects->removeElement($trackerProject)) {
            // set the owning side to null (unless already changed)
            if ($trackerProject->getDepartment() === $this) {
                $trackerProject->setDepartment(null);
            }
        }

        return $this;
    }
}
