<?php

namespace ExpenseManagement\Domain\ValueObject;

class Date
{
    private $date;
    
    public function __construct($date)
    {
        $this->date = $date;
    }

    public function __toString()
    {
        return $this->date;
    }
}
