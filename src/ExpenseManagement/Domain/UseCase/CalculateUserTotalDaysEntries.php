<?php

namespace ExpenseManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\UseCaseInterface;
use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\UseCase\ManageUserExpense;
use ExpenseManagement\Domain\Repository\ExpenseRepository;

class CalculateUserTotalDaysEntries extends ManageUserExpense implements UseCaseInterface
{
    private $userId;
    private $expenseRepository;

    public function __construct($userId, ExpenseRepository $expenseRepository) 
    {
        $this->userId = $userId;
        $this->expenseRepository = $expenseRepository;
    }

    public function validate()
    {
        $this->validateUserIdIsNotEmpty($this->userId);
    }

    public function perform()
    {
        return $this->expenseRepository->getUserTotalDaysEntries(new UserId($this->userId));
    }
}
