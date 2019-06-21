<?php

namespace ExpenseManagement\Domain\DataTransferObject;

use ExpenseManagement\Domain\ValueObject\Cost;
use ExpenseManagement\Domain\ValueObject\Date;
use ExpenseManagement\Domain\ValueObject\Label;

class ExpenseData 
{
    public $label;
    public $cost;
    public $date;

    public function __construct(
        Label $label, 
        Cost $cost,
        Date $date
    ) {
        $this->label = $label;
        $this->cost = $cost;
        $this->date = $date;
    }
}
