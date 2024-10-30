<?php

namespace App\Entity;

use App\Repository\TrackerProjectRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrackerProjectRepository::class)]
class TrackerProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'trackerProjects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tracker $tracker = null;

    #[ORM\ManyToOne(inversedBy: 'trackerProjects')]
    private ?Project $project = null;

    #[ORM\ManyToOne(inversedBy: 'trackerProjects')]
    private ?Contract $contract = null;

    #[ORM\ManyToOne(inversedBy: 'trackerProjects')]
    private ?ContractDepartment $department = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1)]
    private ?string $regular = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1)]
    private ?string $overtime = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1)]
    private ?string $holiday = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTracker(): ?Tracker
    {
        return $this->tracker;
    }

    public function setTracker(?Tracker $tracker): static
    {
        $this->tracker = $tracker;

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

    public function getContract(): ?Contract
    {
        return $this->contract;
    }

    public function setContract(?Contract $contract): static
    {
        $this->contract = $contract;

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

    public function getRegular(): ?string
    {
        return $this->regular;
    }

    public function setRegular(string $regular): static
    {
        $this->regular = $regular;

        return $this;
    }

    public function getOvertime(): ?string
    {
        return $this->overtime;
    }

    public function setOvertime(string $overtime): static
    {
        $this->overtime = $overtime;

        return $this;
    }

    public function getHoliday(): ?string
    {
        return $this->holiday;
    }

    public function setHoliday(string $holiday): static
    {
        $this->holiday = $holiday;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
