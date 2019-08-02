<?php

namespace ExpenseManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use ExpenseManagement\Domain\Entity\CalculateUserTotalDays;
use ExpenseManagement\Domain\Repository\CalculateUserTotalDaysRepository;

class CalculateUserTotalDaysRepositoryImpl implements CalculateUserTotalDaysRepository
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get(CalculateUserTotalDays $calculateUserTotalDays): int
    {
        $queryBuilder = $this->entityManager->getRepository(CalculateUserTotalDays::class)
                                            ->createQueryBuilder('ue');
        $queryBuilder->select('COUNT(ue.id)');
        $queryBuilder->where("ue.deletedAt = '' AND ue.userId = :userId");
        $queryBuilder->setParameter('userId', $calculateUserTotalDays->userId());

        $total = $queryBuilder->getQuery()->getSingleScalarResult();

        return ($total ? $total : 0);
    }
}
