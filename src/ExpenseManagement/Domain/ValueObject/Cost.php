<?php

namespace ExpenseManagement\Domain\ValueObject;

class Cost
{
    private $cost;
    
    public function __construct(float $cost)
    {
        $this->cost = $cost;
    }

    public function get()
    {
        return $this->cost;
    }
}
