<?php

namespace ExpenseManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;
use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\Entity\ExpenseDeletion;
use ExpenseManagement\Domain\Message\DeleteExpenseData;
use ExpenseManagement\Domain\Repository\ExpenseDeletionRepository;
use ExpenseManagement\Domain\ValueObject\ExpenseId;

class DeleteExpenseAction implements UseCaseInterface
{
    private $deleteExpenseData;
    private $expenseDeletionRepository;

    public function __construct(
        DeleteExpenseData $deleteExpenseData, 
        ExpenseDeletionRepository $expenseDeletionRepository
    ) {
        $this->deleteExpenseData = $deleteExpenseData;
        $this->expenseDeletionRepository = $expenseDeletionRepository;
    }

    public function perform()
    {
        $expenseDeletionEntity = new ExpenseDeletion(
            new ExpenseId($this->deleteExpenseData->expenseId),
            new UserId($this->deleteExpenseData->userId)
        );

        $expenseDeletionEntity->softDelete(new CreatedAt());
        
        return $this->expenseDeletionRepository->save($expenseDeletionEntity);      
    }
}
