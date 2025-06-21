<?php

namespace App\Service;

use App\Entity\Projects;
use Doctrine\ORM\EntityManagerInterface;


class ProjectService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    public function createProject(array $projectData): Projects {

        $existingProject = $this->entityManager
            ->getRepository(Projects::class)
            ->findOneBy(['title' => $projectData['title']]);

        if ($existingProject) {
            throw new \Exception('Проект с таким названием уже существует');
        }

        $project = new Projects();
        $project->setTitle($projectData['title']);
        $project->setUserId($projectData['user']);

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $project;
    }

    public function updateProject(array $projectData): Projects
    {
        if (empty($projectData['id'])) {
            throw new \Exception('ID проекта не указан');
        }

        $project = $this->entityManager
            ->getRepository(Projects::class)
            ->find($projectData['id']);

        if (!$project) {
            throw new \Exception('Проект не найден');
        }

        if ($project->getUserId() !== $projectData['user']->getId())  {
            throw new \Exception('У вас нет прав на редактирование этого проекта');
        }

        if (!empty($projectData['title'])) {
            $existingProject = $this->entityManager
                ->getRepository(Projects::class)
                ->findOneBy(['title' => $projectData['title']]);

            if ($existingProject && $existingProject->getId() !== $project->getId()) {
                throw new \Exception('Проект с таким названием уже существует');
            }

            $project->setTitle($projectData['title']);
        }

        $this->entityManager->flush();

        return $project;
    }
}
