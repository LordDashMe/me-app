<?php

namespace ExpenseManagement\Domain\Message;

class EditExpenseData 
{
    public $expenseId;
    public $userId;
    public $type;
    public $label;
    public $cost;
    public $date;

    public function __construct(
        string $expenseId,
        string $userId, 
        string $type,
        string $label,
        float $cost,
        string $date
    ) {
        $this->expenseId = $expenseId;
        $this->userId = $userId;
        $this->type = $type;
        $this->label = $label;
        $this->cost = $cost;
        $this->date = $date;
    }
}
