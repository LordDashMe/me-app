<?php

namespace ExpenseManagement\Domain\UseCase;

use DomainCommon\Domain\ValueObject\CreatedAt;
use DomainCommon\Domain\UseCase\UseCaseInterface;
use DomainCommon\Domain\UseCase\ValidateRequireFields;
use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\Entity\Expense;
use ExpenseManagement\Domain\ValueObject\Cost;
use ExpenseManagement\Domain\ValueObject\Date;
use ExpenseManagement\Domain\ValueObject\Label;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\UseCase\ManageUserExpense;
use ExpenseManagement\Domain\Repository\ExpenseRepository;

class AddExpense extends ManageUserExpense implements UseCaseInterface
{
    private $requiredFields = [
        'label' => 'Label',
        'cost' => 'Cost',
        'date' => 'Date'
    ];

    private $userId;
    private $addExpenseData = [];
    private $expenseRepository;

    public function __construct($userId, $addExpenseData, ExpenseRepository $expenseRepository) 
    {
        $this->userId = $userId;
        $this->addExpenseData = $addExpenseData;
        $this->expenseRepository = $expenseRepository;
    }

    public function validate()
    {
        $this->validateUserIdIsNotEmpty($this->userId);

        (new ValidateRequireFields($this->requiredFields, $this->addExpenseData))->perform();
    }

    public function perform()
    {
        $this->expenseRepository->create($this->composeExpenseEntity());
    }

    private function composeExpenseEntity()
    {
        return new Expense(
            new ExpenseId(),
            new UserId($this->userId),
            new Label($this->addExpenseData['label']),
            new Cost($this->addExpenseData['cost']),
            new Date($this->addExpenseData['date']),
            new CreatedAt()
        );
    }
}
