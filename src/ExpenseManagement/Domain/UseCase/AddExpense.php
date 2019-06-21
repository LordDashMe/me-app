<?php

namespace ExpenseManagement\Domain\UseCase;

use DomainCommon\Domain\Service\UniqueIDResolver;
use DomainCommon\Domain\UseCase\UseCaseInterface;
use DomainCommon\Domain\UseCase\ValidateRequireFields;
use DomainCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\DataTransferObject\ExpenseData;
use ExpenseManagement\Domain\Entity\Expense;
use ExpenseManagement\Domain\Repository\ExpenseRepository;
use ExpenseManagement\Domain\UseCase\ManageUserExpense;
use ExpenseManagement\Domain\ValueObject\Cost;
use ExpenseManagement\Domain\ValueObject\Date;
use ExpenseManagement\Domain\ValueObject\Label;
use ExpenseManagement\Domain\ValueObject\ExpenseId;

class AddExpense extends ManageUserExpense implements UseCaseInterface
{
    private $userId;
    private $expenseData;
    private $expenseRepository;
    private $uniqueIDResolver;

    public function __construct(
        UserId $userId, 
        ExpenseData $expenseData, 
        ExpenseRepository $expenseRepository,
        UniqueIDResolver $uniqueIDResolver
    ) {
        $this->userId = $userId;
        $this->expenseData = $expenseData;
        $this->expenseRepository = $expenseRepository;
    }

    public function validate(): void
    {
        $this->validateUserIdIsNotEmpty($this->userId);

        $this->expenseData->label->required();
        $this->expenseData->cost->required();
        $this->expenseData->date->required();
    }

    public function perform()
    {
        $this->expenseRepository->create(
            new Expense(
                new ExpenseId($this->uniqueIDResolver->generate()),
                $this->userId,
                $this->expenseData->label,
                $this->expenseData->cost,
                $this->expenseData->date,
                new CreatedAt()
            )
        );
    }
}
