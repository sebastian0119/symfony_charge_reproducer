<?php

namespace App\Entity;

use App\Repository\TrackerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrackerRepository::class)]
class Tracker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'trackers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?bool $submitted = null;

    #[ORM\Column]
    private ?bool $authorized = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $authorizedBy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $authorizedOn = null;

    #[ORM\OneToMany(mappedBy: 'tracker', targetEntity: TrackerProject::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $trackerProjects;

    #[ORM\OneToMany(mappedBy: 'tracker', targetEntity: TrackerExpense::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $trackerExpenses;

    #[ORM\ManyToOne(inversedBy: 'trackers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserAnalysis $userAnalysis = null;

    public function __construct()
    {
        $this->trackerProjects = new ArrayCollection();
        $this->trackerExpenses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function isSubmitted(): ?bool
    {
        return $this->submitted;
    }

    public function setSubmitted(bool $submitted): static
    {
        $this->submitted = $submitted;

        return $this;
    }

    public function isAuthorized(): ?bool
    {
        return $this->authorized;
    }

    public function setAuthorized(bool $authorized): static
    {
        $this->authorized = $authorized;

        return $this;
    }

    public function getAuthorizedBy(): ?string
    {
        return $this->authorizedBy;
    }

    public function setAuthorizedBy(?string $authorizedBy): static
    {
        $this->authorizedBy = $authorizedBy;

        return $this;
    }

    public function getAuthorizedOn(): ?\DateTimeInterface
    {
        return $this->authorizedOn;
    }

    public function setAuthorizedOn(?\DateTimeInterface $authorizedOn): static
    {
        $this->authorizedOn = $authorizedOn;

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
            $trackerProject->setTracker($this);
        }

        return $this;
    }

    public function removeTrackerProject(TrackerProject $trackerProject): static
    {
        if ($this->trackerProjects->removeElement($trackerProject)) {
            // set the owning side to null (unless already changed)
            if ($trackerProject->getTracker() === $this) {
                $trackerProject->setTracker(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TrackerExpense>
     */
    public function getTrackerExpenses(): Collection
    {
        return $this->trackerExpenses;
    }

    public function addTrackerExpense(TrackerExpense $trackerExpense): static
    {
        if (!$this->trackerExpenses->contains($trackerExpense)) {
            $this->trackerExpenses->add($trackerExpense);
            $trackerExpense->setTracker($this);
        }

        return $this;
    }

    public function removeTrackerExpense(TrackerExpense $trackerExpense): static
    {
        if ($this->trackerExpenses->removeElement($trackerExpense)) {
            // set the owning side to null (unless already changed)
            if ($trackerExpense->getTracker() === $this) {
                $trackerExpense->setTracker(null);
            }
        }

        return $this;
    }

    public function getUserAnalysis(): ?UserAnalysis
    {
        return $this->userAnalysis;
    }

    public function setUserAnalysis(?UserAnalysis $userAnalysis): static
    {
        $this->userAnalysis = $userAnalysis;

        return $this;
    }
}
