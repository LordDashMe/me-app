<?php

namespace ExpenseManagement\Domain\ValueObject;

class Type
{
    private $type;
    
    public function __construct($type)
    {
        $this->type = $type;
    }

    public function __toString()
    {
        return $this->type;
    }
}
