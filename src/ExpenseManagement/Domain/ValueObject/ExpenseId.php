<?php

namespace ExpenseManagement\Domain\ValueObject;

class ExpenseId
{
    private $expenseId;
    
    public function __construct($expenseId = '')
    {
        $this->expenseId = $expenseId ?: \uniqid();
    }

    public function get()
    {
        return $this->expenseId;
    }
}
