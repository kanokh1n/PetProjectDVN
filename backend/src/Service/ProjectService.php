<?php

namespace App\Service;

use App\Entity\ProjectInfo;
use App\Entity\Projects;
use App\Repository\ProjectsRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProjectService
{
    public function __construct(
        private readonly ProjectsRepository $projectsRepository,
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function createProject(array $projectData): Projects {

        if ($this->projectsRepository->existsByTitle($projectData['title'])) {
            throw new \Exception('Project with this title already exists');
        }

        $projectInfo = new ProjectInfo();
        $project = new Projects();

        $project->setTitle($projectData['title']);
        $project->setUser($projectData['user']);
        $projectInfo->setCurrentAmount(0);
        $projectInfo->setGoalAmount($projectData['goalAmount']);
        $project->setProjectInfo($projectInfo);

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $project;
    }

    public function updateProject(array $projectData): Projects
    {
        if (empty($projectData['id'])) {
            throw new \Exception('Project id is required');
        }

        $existingProject = $this->projectsRepository->findOneById($projectData['id']);

        if (!$existingProject) {
            throw new \Exception('Project not found');
        }

        if ($existingProject->getUser()->getId() !== $projectData['user']->getId())  {
            throw new \Exception('You can not edit this project');
        }

        if ($this->projectsRepository->findOneByTitle($projectData['title']) == $existingProject->getTitle()) {
            throw new \Exception('Project with this title already exists');
        }

        $existingProject->setTitle($projectData['title']);
        $this->entityManager->flush();

        return $existingProject;
    }
}
