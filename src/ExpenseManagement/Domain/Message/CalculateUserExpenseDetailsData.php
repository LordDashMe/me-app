<?php

namespace ExpenseManagement\Domain\Message;

class CalculateUserExpenseDetailsData 
{
    public $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }
}
