<?php

namespace ExpenseManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\UseCaseInterface;
use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\UseCase\ManageUserExpense;
use ExpenseManagement\Domain\Repository\ExpenseRepository;
use ExpenseManagement\Domain\Exception\ManageUserFailedException;

class DeleteExpense extends ManageUserExpense implements UseCaseInterface
{
    private $expenseId;
    private $userId;
    private $expenseRepository;

    public function __construct($expenseId, $userId, ExpenseRepository $expenseRepository) 
    {
        $this->expenseId = $expenseId;
        $this->userId = $userId;
        $this->expenseRepository = $expenseRepository;
    }

    public function validate()
    {
        $this->validateExpenseIdIsNotEmpty($this->expenseId);
        $this->validateUserIdIsNotEmpty($this->userId);
    }

    public function perform()
    {
        return $this->expenseRepository->softDelete(
            new ExpenseId($this->expenseId), 
            new UserId($this->userId)
        );      
    }
}
