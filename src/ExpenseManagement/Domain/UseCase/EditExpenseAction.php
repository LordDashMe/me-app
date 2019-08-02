<?php

namespace ExpenseManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;
use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\Entity\ExpenseModification;
use ExpenseManagement\Domain\Message\EditExpenseData;
use ExpenseManagement\Domain\Repository\ExpenseModificationRepository;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\ValueObject\Type;
use ExpenseManagement\Domain\ValueObject\Label;
use ExpenseManagement\Domain\ValueObject\Cost;
use ExpenseManagement\Domain\ValueObject\Date;

class EditExpenseAction implements UseCaseInterface
{
    private $editExpenseData;
    private $expenseModificationRepository;

    public function __construct(
        EditExpenseData $editExpenseData,
        ExpenseModificationRepository $expenseModificationRepository
    ) {
        $this->editExpenseData = $editExpenseData;
        $this->expenseModificationRepository = $expenseModificationRepository;
    }

    public function perform()
    {
        $expenseModificationEntity = new ExpenseModification(
            new ExpenseId($this->editExpenseData->expenseId),
            new UserId($this->editExpenseData->userId) 
        );

        $expenseModificationEntity->changeType(new Type($this->editExpenseData->type));
        $expenseModificationEntity->changeLabel(new Label($this->editExpenseData->label));
        $expenseModificationEntity->changeCost(new Cost($this->editExpenseData->cost));
        $expenseModificationEntity->changeDate(new Date($this->editExpenseData->date));

        return $this->expenseModificationRepository->save($expenseModificationEntity);
    }
}
