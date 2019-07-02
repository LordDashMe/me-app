<?php

namespace ExpenseManagement\Domain\Message;

class DeleteExpenseData 
{
    public $expenseId;
    public $userId;

    public function __construct(string $expenseId, string $userId)
    {
        $this->expenseId = $expenseId;
        $this->userId = $userId;
    }
}
