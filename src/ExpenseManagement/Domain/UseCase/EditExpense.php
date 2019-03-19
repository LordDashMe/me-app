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

class EditExpense extends ManageUserExpense implements UseCaseInterface
{
    private $requiredFields = [
        'label' => 'Label',
        'cost' => 'Cost',
        'date' => 'Date'
    ];

    private $expenseId;
    private $editExpenseData = [];
    private $expenseRepository;

    public function __construct($expenseId, $editExpenseData, ExpenseRepository $expenseRepository) 
    {
        $this->expenseId = $expenseId;
        $this->editExpenseData = $editExpenseData;
        $this->expenseRepository = $expenseRepository;
    }

    public function validate()
    {
        $this->validateExpenseIdIsNotEmpty($this->expenseId);
        
        (new ValidateRequireFields($this->requiredFields, $this->editExpenseData))->perform();
    }

    public function perform()
    {
        $this->expenseRepository->update($this->composeExpenseEntity());
    }

    private function composeExpenseEntity()
    {
        $currentExpenseEntity = $this->getCurrentExpenseEntityUsingId();

        return new Expense(
            new ExpenseId($this->expenseId),
            new UserId($currentExpenseEntity->getUserId()),
            new Label($this->editExpenseData['label']),
            new Cost($this->editExpenseData['cost']),
            new Date($this->editExpenseData['date']),
            new CreatedAt($currentExpenseEntity->getCreatedAt())
        );
    }

    private function getCurrentExpenseEntityUsingId() 
    {
        return $this->expenseRepository->get(new ExpenseId($this->expenseId));
    }
}
