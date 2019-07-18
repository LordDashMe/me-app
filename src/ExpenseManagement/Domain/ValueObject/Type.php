<?php

namespace ExpenseManagement\Domain\ValueObject;

class Type
{
    private $type;
    
    public function __construct($type)
    {
        $this->type = $type;
    }

    public function get()
    {
        return $this->type;
    }
}
