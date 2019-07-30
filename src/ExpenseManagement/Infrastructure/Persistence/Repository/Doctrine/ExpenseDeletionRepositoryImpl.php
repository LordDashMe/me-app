<?php

namespace ExpenseManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use ExpenseManagement\Domain\Entity\ExpenseDeletion;
use ExpenseManagement\Domain\Repository\ExpenseDeletionRepository;
use ExpenseManagement\Domain\ValueObject\ExpenseId;

class ExpenseDeletionRepositoryImpl implements ExpenseDeletionRepository
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(ExpenseDeletion $expenseDeletion): ExpenseId
    {
        $this->entityManager->merge($expenseDeletion);
        $this->entityManager->flush();

        return new ExpenseId($expenseDeletion->id());
    }
}
