<?php

namespace ExpenseManagement\Domain\Repository;

use ExpenseManagement\Domain\Entity\CalculateUserTotalDays;

interface CalculateUserTotalDaysRepository
{
    public function get(CalculateUserTotalDays $calculateUserTotalDays): int;
}
