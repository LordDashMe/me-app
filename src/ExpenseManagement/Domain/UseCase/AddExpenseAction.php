<?php

namespace ExpenseManagement\Domain\UseCase;

use AppCommon\Domain\Service\UniqueIDResolver;
use AppCommon\Domain\UseCase\UseCaseInterface;
use AppCommon\Domain\ValueObject\CreatedAt;

use ExpenseManagement\Domain\Entity\AddExpense;
use ExpenseManagement\Domain\Message\AddExpenseData;
use ExpenseManagement\Domain\Repository\AddExpenseRepository;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\ValueObject\Type;
use ExpenseManagement\Domain\ValueObject\Label;
use ExpenseManagement\Domain\ValueObject\Cost;
use ExpenseManagement\Domain\ValueObject\Date;

class AddExpenseAction implements UseCaseInterface
{
    private $addExpenseData;
    private $addExpenseRepository;
    private $uniqueIDResolver;

    private $addExpenseEntity;

    public function __construct(
        AddExpenseData $addExpenseData, 
        AddExpenseRepository $addExpenseRepository,
        UniqueIDResolver $uniqueIDResolver
    ) {
        $this->addExpenseData = $addExpenseData;
        $this->addExpenseRepository = $addExpenseRepository;
        $this->uniqueIDResolver = $uniqueIDResolver;
    }

    public function perform()
    {
        $this->addExpenseEntity = new AddExpense(
            new Type($this->addExpenseData->type),
            new Label($this->addExpenseData->label),
            new Cost($this->addExpenseData->cost),
            new Date($this->addExpenseData->date),
            new CreatedAt()
        );

        $this->generateUniqueId();

        $this->addExpenseRepository->save($this->addExpenseEntity);
    }

    private function generateUniqueId()
    {
        $this->addExpenseEntity->provideUniqueId(
            new ExpenseId($this->uniqueIDResolver->generate()) 
        );
    }
}
