<?php

namespace ExpenseManagement\Domain\UseCase;

use ExpenseManagement\Domain\Exception\ManageUserExpenseFailedException;

class ManageUserExpense
{
    protected function validateExpenseIdIsNotEmpty($expenseId)
    {
        if (empty($expenseId)) {
            throw ManageUserExpenseFailedException::expenseIdIsEmpty();
        }
    }

    protected function validateUserIdIsNotEmpty($userId)
    {
        if (empty($userId)) {
            throw ManageUserExpenseFailedException::userIdIsEmpty();
        }
    }
}
