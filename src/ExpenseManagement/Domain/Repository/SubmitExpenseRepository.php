<?php

namespace ExpenseManagement\Domain\Repository;

use ExpenseManagement\Domain\Entity\SubmitExpense;

interface SubmitExpenseRepository
{
    public function save(SubmitExpense $submitExpense): void;
}
