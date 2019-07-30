<?php

namespace ExpenseManagement\Domain\ValueObject;

class Type
{
    private $type;
    
    public function __construct(int $type)
    {
        $this->type = $type;
    }

    public function get()
    {
        return $this->type;
    }
}
