<?php

namespace ExpenseManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use ExpenseManagement\Domain\Entity\CalculateUserTotalExpenses;
use ExpenseManagement\Domain\Repository\CalculateUserTotalExpensesRepository;

class CalculateUserTotalExpensesRepositoryImpl implements CalculateUserTotalExpensesRepository
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get(CalculateUserTotalExpenses $calculateUserTotalExpenses): int
    {
        $queryBuilder = $this->entityManager->getRepository(CalculateUserTotalExpenses::class)
                                            ->createQueryBuilder('ue');
        $queryBuilder->select('SUM(ue.cost)');
        $queryBuilder->where("ue.deletedAt = '' AND ue.userId = :userId");
        $queryBuilder->setParameter('userId', $calculateUserTotalExpenses->userId());

        $total = $queryBuilder->getQuery()->getSingleScalarResult();

        return ($total ? $total : 0);
    }
}
