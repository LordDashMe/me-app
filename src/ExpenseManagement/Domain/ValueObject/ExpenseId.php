<?php

namespace ExpenseManagement\Domain\ValueObject;

class ExpenseId
{
    private $expenseId;
    
    public function __construct(string $expenseId = '')
    {
        $this->expenseId = $expenseId;
    }

    public function get(): string
    {
        return $this->expenseId;
    }
}
