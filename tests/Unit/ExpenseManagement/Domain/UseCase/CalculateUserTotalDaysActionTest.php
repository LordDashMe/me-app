<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use ExpenseManagement\Domain\Message\CalculateUserExpenseDetailsData;
use ExpenseManagement\Domain\Repository\CalculateUserTotalDaysRepository;

use ExpenseManagement\Domain\UseCase\CalculateUserTotalDaysAction;

class CalculateUserTotalDaysActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_main_class()
    {
        $useCase = new CalculateUserTotalDaysAction(
            Mockery::mock(CalculateUserExpenseDetailsData::class),
            Mockery::mock(CalculateUserTotalDaysRepository::class)
        );

        $this->assertInstanceOf(CalculateUserTotalDaysAction::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_calculate_total_days()
    {
        $calculateUserExpenseDetailsData = new CalculateUserExpenseDetailsData('UUID001');

        $calculateUserTotalDaysRepository = Mockery::mock(CalculateUserTotalDaysRepository::class);
        $calculateUserTotalDaysRepository->shouldReceive('get')
                                         ->andReturn(5);

        $useCase = new CalculateUserTotalDaysAction(
            $calculateUserExpenseDetailsData,
            $calculateUserTotalDaysRepository
        );

        $this->assertEquals(5, $useCase->perform());
    }
}
