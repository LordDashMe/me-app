<?php

namespace ExpenseManagement\Domain\Repository;

use ExpenseManagement\Domain\Entity\ExpenseDeletion;

interface ExpenseDeletionRepository
{
    public function save(ExpenseDeletion $expenseDeletion);
}
