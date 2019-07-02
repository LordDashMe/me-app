<?php

namespace ExpenseManagement\Domain\Repository;

use ExpenseManagement\Domain\Entity\CalculateUserTotalExpenses;

interface CalculateUserTotalExpensesRepository
{
    public function get(CalculateUserTotalExpenses $calculateUserTotalExpenses): int;
}
