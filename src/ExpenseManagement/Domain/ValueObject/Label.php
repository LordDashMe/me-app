<?php

namespace ExpenseManagement\Domain\ValueObject;

class Label
{
    private $label;
    
    public function __construct($label)
    {
        $this->label = $label;
    }

    public function __toString()
    {
        return $this->label;
    }
}
