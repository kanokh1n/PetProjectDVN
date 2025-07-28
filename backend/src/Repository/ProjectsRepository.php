<?php

namespace App\Repository;

use App\Entity\Projects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Projects>
 */
class ProjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projects::class);
    }

    /**
     * Находит проект по названию
     */
    public function findOneByTitle(string $title): ?Projects
    {
        return $this->findOneBy(['title' => $title]);
    }

    /**
     * Находит проект по ID
     */
    public function findOneById(int $id): ?Projects
    {
        return $this->find($id);
    }

    /**
     * Проверяет существование проекта по названию
     */
    public function existsByTitle(string $title): bool
    {
        return null !== $this->findOneByTitle($title);
    }
}
