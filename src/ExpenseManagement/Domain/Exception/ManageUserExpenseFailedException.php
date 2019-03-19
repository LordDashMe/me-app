<?php

namespace ExpenseManagement\Domain\Exception;

use Exception;

class ManageUserExpenseFailedException extends Exception
{
    const EXPENSE_ID_IS_EMPTY = 1;
    const USER_ID_IS_EMPTY = 2;

    public static function expenseIdIsEmpty($previous = null) 
    {
        $message = 'The given expense id is empty.';
        $code = self::EXPENSE_ID_IS_EMPTY;

        return new self($message, $code, $previous);
    }

    public static function userIdIsEmpty($previous = null) 
    {
        $message = 'The given user id is empty.';
        $code = self::USER_ID_IS_EMPTY;

        return new self($message, $code, $previous);
    }
}
