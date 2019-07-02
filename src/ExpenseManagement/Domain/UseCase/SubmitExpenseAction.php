<?php

namespace ExpenseManagement\Domain\UseCase;

use AppCommon\Domain\Service\UniqueIDResolver;
use AppCommon\Domain\UseCase\UseCaseInterface;
use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\Entity\SubmitExpense;
use ExpenseManagement\Domain\Message\SubmitExpenseData;
use ExpenseManagement\Domain\Repository\SubmitExpenseRepository;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\ValueObject\Type;
use ExpenseManagement\Domain\ValueObject\Label;
use ExpenseManagement\Domain\ValueObject\Cost;
use ExpenseManagement\Domain\ValueObject\Date;

class SubmitExpenseAction implements UseCaseInterface
{
    private $submitExpenseData;
    private $submitExpenseRepository;
    private $uniqueIDResolver;

    private $submitExpenseEntity;

    public function __construct(
        SubmitExpenseData $submitExpenseData, 
        SubmitExpenseRepository $submitExpenseRepository,
        UniqueIDResolver $uniqueIDResolver
    ) {
        $this->submitExpenseData = $submitExpenseData;
        $this->submitExpenseRepository = $submitExpenseRepository;
        $this->uniqueIDResolver = $uniqueIDResolver;
    }

    public function perform()
    {
        $this->submitExpenseEntity = new SubmitExpense(
            new UserId($this->submitExpenseData->userId),
            new Type($this->submitExpenseData->type),
            new Label($this->submitExpenseData->label),
            new Cost($this->submitExpenseData->cost),
            new Date($this->submitExpenseData->date),
            new CreatedAt()
        );

        $this->generateUniqueId();

        $this->submitExpenseRepository->save($this->submitExpenseEntity);
    }

    private function generateUniqueId()
    {
        $this->submitExpenseEntity->provideUniqueId(
            new ExpenseId($this->uniqueIDResolver->generate()) 
        );
    }
}
