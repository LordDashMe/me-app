<?php

namespace ExpenseManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use ExpenseManagement\Domain\Entity\SubmitExpense;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\Repository\SubmitExpenseRepository;

class SubmitExpenseRepositoryImpl implements SubmitExpenseRepository
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(SubmitExpense $submitExpense): ExpenseId
    {
        $this->entityManager->persist($submitExpense);
        $this->entityManager->flush();

        return new ExpenseId($submitExpense->id());
    }
}
