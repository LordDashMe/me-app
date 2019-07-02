<?php

namespace ExpenseManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\Entity\CalculateUserTotalDays;
use ExpenseManagement\Domain\Message\CalculateUserExpenseDetailsData;
use ExpenseManagement\Domain\Repository\CalculateUserTotalDaysRepository;

class CalculateUserTotalDaysAction implements UseCaseInterface
{
    private $calucateUserExpenseDetailsData;
    private $calculateUserTotalDaysRepository;

    public function __construct(
        CalculateUserExpenseDetailsData $calucateUserExpenseDetailsData, 
        CalculateUserTotalDaysRepository $calculateUserTotalDaysRepository
    ) {
        $this->calucateUserExpenseDetailsData = $calucateUserExpenseDetailsData;
        $this->calculateUserTotalDaysRepository = $calculateUserTotalDaysRepository;
    }

    public function perform()
    {
        return $this->calculateUserTotalDaysRepository->get(
            new CalculateUserTotalDays(
                new UserId($this->calucateUserExpenseDetailsData->userId)
            )
        );
    }
}
