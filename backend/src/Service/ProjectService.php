<?php

namespace App\Service;

use App\Entity\Projects;
use App\Repository\ProjectsRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProjectService
{
    public function __construct(private readonly ProjectsRepository $projectsRepository,
                                private readonly EntityManagerInterface $entityManager
    ) {}

    public function createProject(array $projectData): Projects {

        if ($this->projectsRepository->existsByTitle($projectData['title'])) {
            throw new \Exception('Проект с таким названием уже существует');
        }

        $project = new Projects();
        $project->setTitle($projectData['title']);
        $project->setUser($projectData['user']);

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $project;
    }

    public function updateProject(array $projectData): Projects
    {
        if (empty($projectData['id'])) {
            throw new \Exception('ID проекта не указан');
        }

        $existingProject = $this->projectsRepository->findOneById($projectData['id']);

        if (!$existingProject) {
            throw new \Exception('Проект не найден');
        }

        if ($existingProject->getUser()->getId() !== $projectData['user']->getId())  {
            throw new \Exception('У вас нет прав на редактирование этого проекта');
        }

        if ($this->projectsRepository->findOneByTitle($projectData['title']) == $existingProject->getTitle()) {
            throw new \Exception('Проект с таким названием уже существует');
        }

        $existingProject->setTitle($projectData['title']);
        $this->entityManager->flush();

        return $existingProject;
    }
}
