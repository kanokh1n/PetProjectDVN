<?php

namespace App\Entity;

use App\Repository\ProjectInfoRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ProjectInfoRepository::class)]
class ProjectInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'projectInfo', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Projects $projects = null;

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $github_link = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tg_link = null;

    #[ORM\Column]
    private ?int $current_amount = null;

    #[ORM\Column]
    private ?int $goal_amount = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    #[Gedmo\Timestampable(on: 'update')]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProject(): ?Projects
    {
        return $this->projects;
    }

    public function setProject(Projects $projects): static
    {
        $this->projects = $projects;

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

    public function getGithubLink(): ?string
    {
        return $this->github_link;
    }

    public function setGithubLink(?string $github_link): static
    {
        $this->github_link = $github_link;

        return $this;
    }

    public function getTgLink(): ?string
    {
        return $this->tg_link;
    }

    public function setTgLink(?string $tg_link): static
    {
        $this->tg_link = $tg_link;

        return $this;
    }

    public function getCurrentAmount(): ?int
    {
        return $this->current_amount;
    }

    public function setCurrentAmount(int $current_amount): static
    {
        $this->current_amount = $current_amount;

        return $this;
    }

    public function getGoalAmount(): ?int
    {
        return $this->goal_amount;
    }

    public function setGoalAmount(int $goal_amount): static
    {
        $this->goal_amount = $goal_amount;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
