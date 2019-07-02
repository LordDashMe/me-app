<?php

namespace ExpenseManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\Entity\CalculateUserTotalExpenses;
use ExpenseManagement\Domain\Message\CalculateUserExpenseDetailsData;
use ExpenseManagement\Domain\Repository\CalculateUserTotalExpensesRepository;

class CalculateUserTotalExpensesAction implements UseCaseInterface
{
    private $calucateUserExpenseDetailsData;
    private $calculateUserTotalExpensesRepository;

    public function __construct(
        CalculateUserExpenseDetailsData $calucateUserExpenseDetailsData, 
        CalculateUserTotalExpensesRepository $calculateUserTotalExpensesRepository
    ) {
        $this->calucateUserExpenseDetailsData = $calucateUserExpenseDetailsData;
        $this->calculateUserTotalExpensesRepository = $calculateUserTotalExpensesRepository;
    }

    public function perform()
    {
        return $this->calculateUserTotalExpensesRepository->get(
            new CalculateUserTotalExpenses(
                new UserId($this->calucateUserExpenseDetailsData->userId)
            )
        );
    }
}
