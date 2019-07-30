<?php

namespace ExpenseManagement\Domain\ValueObject;

class Label
{
    private $label;
    
    public function __construct(string $label)
    {
        $this->label = $label;
    }

    public function get()
    {
        return $this->label;
    }
}
