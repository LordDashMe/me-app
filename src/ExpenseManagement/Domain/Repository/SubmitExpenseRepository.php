<?php

namespace ExpenseManagement\Domain\Repository;

use ExpenseManagement\Domain\Entity\SubmitExpense;
use ExpenseManagement\Domain\ValueObject\ExpenseId;

interface SubmitExpenseRepository
{
    public function save(SubmitExpense $submitExpense): ExpenseId;
}
