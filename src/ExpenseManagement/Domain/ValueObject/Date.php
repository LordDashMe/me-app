<?php

namespace ExpenseManagement\Domain\ValueObject;

class Date
{
    private $date;
    
    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function get()
    {
        return $this->date;
    }
}
