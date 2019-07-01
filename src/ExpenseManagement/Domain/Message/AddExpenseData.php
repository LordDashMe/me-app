<?php

namespace ExpenseManagement\Domain\Message;

class AddExpenseData 
{
    public $userId;
    public $type;
    public $label;
    public $cost;
    public $date;

    public function __construct(
        string $userId,
        string $type,
        string $label, 
        float $cost,
        string $date
    ) {
        $this->userId = $userId;
        $this->type = $type;
        $this->label = $label;
        $this->cost = $cost;
        $this->date = $date;
    }
}
