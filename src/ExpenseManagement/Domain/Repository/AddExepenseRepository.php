<?php

namespace ExpenseManagement\Domain\Repository;

use ExpenseManagement\Domain\Entity\AddExpense;

interface AddExpenseRepository
{
    public function save(AddExpense $addExpense): void;
}
