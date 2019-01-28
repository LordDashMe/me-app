<?php

namespace ExpenseManagement\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\Entity\Expense;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\Repository\ExpenseRepository;

class ExpenseRepositoryImpl implements ExpenseRepository
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Expense $expenseEntity)
    {

    }

    public function update(ExpenseId $expenseId, Expense $expenseEntity)
    {
        
    }

    public function findUserExpenses(UserId $userId)
    {

    }

    public function getDataTable()
    {

    }

    public function softDelete(ExpenseId $expenseId)
    {

    }
}
