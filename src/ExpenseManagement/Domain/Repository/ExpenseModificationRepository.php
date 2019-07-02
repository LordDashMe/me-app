<?php

namespace ExpenseManagement\Domain\Repository;

use ExpenseManagement\Domain\Entity\ExpenseModification;

interface ExpenseModificationRepository
{
    public function save(ExpenseModification $expenseModification): void;
    
    public function softDelete(string $expenseId, string $userId): string;
}
