<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use ExpenseManagement\Domain\Message\CalculateUserExpenseDetailsData;
use ExpenseManagement\Domain\Repository\CalculateUserTotalExpensesRepository;

use ExpenseManagement\Domain\UseCase\CalculateUserTotalExpensesAction;

class CalculateUserTotalExpensesActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_main_class()
    {
        $useCase = new CalculateUserTotalExpensesAction(
            Mockery::mock(CalculateUserExpenseDetailsData::class),
            Mockery::mock(CalculateUserTotalExpensesRepository::class)
        );

        $this->assertInstanceOf(CalculateUserTotalExpensesAction::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_calculate_total_expenses()
    {
        $calculateUserExpenseDetailsData = new CalculateUserExpenseDetailsData('UUID001');

        $calculateUserTotalExpensesRepository = Mockery::mock(CalculateUserTotalExpensesRepository::class);
        $calculateUserTotalExpensesRepository->shouldReceive('get')
                                         ->andReturn(1000.00);

        $useCase = new CalculateUserTotalExpensesAction(
            $calculateUserExpenseDetailsData,
            $calculateUserTotalExpensesRepository
        );

        $this->assertEquals(1000.00, $useCase->perform());
    }
}
