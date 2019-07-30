<?php

namespace ExpenseManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use ExpenseManagement\Domain\Entity\ExpenseModification;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\Repository\ExpenseModificationRepository;

class ExpenseModificationRepositoryImpl implements ExpenseModificationRepository
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(ExpenseModification $expenseModification): ExpenseId
    {
        $this->entityManager->merge($expenseModification);
        $this->entityManager->flush();

        return new ExpenseId($expenseModification->id());
    }
}
