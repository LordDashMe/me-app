<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\Repository\ExpenseRepository;
use ExpenseManagement\Domain\UseCase\CalculateUserTotalExpenses;

class CalculateUserTotalExpensesTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_add_expense_class()
    {
        $userId = '';

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $this->assertInstanceOf(CalculateUserTotalExpenses::class, new CalculateUserTotalExpenses($userId, $expenseRepository));
    }

    /**
     * @test
     */
    public function it_should_perform_calculate_user_total_days_entries()
    {
        $userId = 'fhqwer1o5';
        
        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $expenseRepository->shouldReceive('getUserTotalExpenses')
                          ->andReturn(1000);

        $calculateUsertotalExpenses = new CalculateUserTotalExpenses($userId, $expenseRepository);
        
        $this->assertEquals(1000, $calculateUsertotalExpenses->perform());
    }
}
