<?php

namespace ExpenseManagement\Domain\Repository;

use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\Entity\Expense;
use ExpenseManagement\Domain\ValueObject\ExpenseId;

interface ExpenseRepository
{
    public function create(Expense $expenseEntity);

    public function update(Expense $expenseEntity);

    public function find(ExpenseId $expenseId);

    public function getDataTable(UserId $userId, $options);

    public function softDelete(ExpenseId $expenseId);

    public function getUserTotalDaysEntries(UserId $userId);

    public function getUserTotalExpenses(UserId $userId);
}
