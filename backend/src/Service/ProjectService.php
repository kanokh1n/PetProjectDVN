<?php

namespace App\Service;

use App\Dto\UpdateProjectRequest;
use App\Entity\ProjectInfo;
use App\Dto\CreateProjectRequest;
use App\Entity\Projects;
use App\Repository\ProjectsRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProjectService
{
    public function __construct(
        private readonly ProjectsRepository $projectsRepository,
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function createProject(CreateProjectRequest $dto): Projects
    {
        if ($this->projectsRepository->existsByTitle($dto->title)) {
            throw new \Exception('Project with this title already exists');
        }

        $projectInfo = new ProjectInfo();
        $project = new Projects();

        $project->setTitle($dto->title);
        $project->setUser($dto->user);

        $projectInfo->setDescription($dto->description);
        $projectInfo->setGithubLink($dto->githubLink);
        $projectInfo->setTgLink($dto->tgLink);
        $projectInfo->setCurrentAmount(0);
        $projectInfo->setGoalAmount($dto->goalAmount);

        $project->setProjectInfo($projectInfo);

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $project;
    }

    public function updateProject(UpdateProjectRequest $dto): Projects
    {
        $existingProject = $this->projectsRepository->findOneByIdWithInfo($dto->id);

        if (!$existingProject) {
            throw new \Exception('Project not found');
        }

        if ($existingProject->getUser()->getId() !== $dto->user->getId()) {
            throw new \Exception('You cannot edit this project');
        }

        $existingByTitle = $this->projectsRepository->findOneByTitle($dto->title);
        if ($existingByTitle && $existingByTitle->getId() !== $dto->id) {
            throw new \Exception('Project with this title already exists');
        }

        $existingProject->setTitle($dto->title);

        $this->entityManager->flush();

        return $existingProject;
    }
}
