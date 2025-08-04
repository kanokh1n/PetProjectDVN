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
     * Find project by title + load ProjectsInfo
     */
    public function findOneByTitleWithInfo(string $title): ?Projects
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.projectInfo', 'info')
            ->addSelect('info')
            ->where('p.title = :title')
            ->setParameter('title', $title)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find project by id + load ProjectsInfo
     */
    public function findOneByIdWithInfo(int $id): ?Projects
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.projectInfo', 'info') // ← ВАЖНО: projectInfo (имя свойства!)
            ->addSelect('info')
            ->where('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find project by title
     */
    public function findOneByTitle(string $title): ?Projects
    {
        return $this->findOneBy(['title' => $title]);
    }

    /**
     * Find project by id
     */
    public function findOneById(int $id): ?Projects
    {
        return $this->find($id);
    }

    /**
     * Checks if a project exists by name
     */
    public function existsByTitle(string $title): bool
    {
        return null !== $this->findOneByTitle($title);
    }
}
