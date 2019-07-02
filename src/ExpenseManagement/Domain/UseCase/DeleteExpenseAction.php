<?php

namespace ExpenseManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\Message\DeleteExpenseData;
use ExpenseManagement\Domain\Repository\ExpenseModificationRepository;
use ExpenseManagement\Domain\ValueObject\ExpenseId;

class DeleteExpenseAction implements UseCaseInterface
{
    private $deleteExpenseData;
    private $expenseModificationRepository;

    public function __construct(
        DeleteExpenseData $deleteExpenseData, 
        ExpenseModificationRepository $expenseModificationRepository
    ) {
        $this->deleteExpenseData = $deleteExpenseData;
        $this->expenseModificationRepository = $expenseModificationRepository;
    }

    public function perform()
    {
        return $this->expenseModificationRepository->softDelete(
            new ExpenseId($this->deleteExpenseData->expenseId),
            new UserId($this->deleteExpenseData->userId)
        );      
    }
}
