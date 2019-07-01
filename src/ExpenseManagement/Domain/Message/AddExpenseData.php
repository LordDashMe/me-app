<?php

namespace ExpenseManagement\Domain\Message;

class AddExpenseData 
{
    public $type;
    public $label;
    public $cost;
    public $date;

    public function __construct(
        string $type,
        string $label, 
        float $cost,
        string $date
    ) {
        $this->type = $type;
        $this->label = $label;
        $this->cost = $cost;
        $this->date = $date;
    }
}
