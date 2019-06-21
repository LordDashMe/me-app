<?php

namespace ExpenseManagement\Domain\UseCase;

use UserManagement\Domain\Exception\ManageUserFailedException;

use ExpenseManagement\Domain\Exception\ManageUserExpenseFailedException;

class ManageUserExpense
{
    protected function validateUserIdIsNotEmpty($userId)
    {
        if (empty($userId->get())) {
            throw ManageUserExpenseFailedException::userIdIsEmpty();
        }
    }

    protected function validateExpenseIdIsNotEmpty($expenseId)
    {
        if (empty($expenseId)) {
            throw ManageUserExpenseFailedException::expenseIdIsEmpty();
        }
    }
}
