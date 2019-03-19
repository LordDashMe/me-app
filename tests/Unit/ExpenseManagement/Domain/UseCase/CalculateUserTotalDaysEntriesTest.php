<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\Repository\ExpenseRepository;
use ExpenseManagement\Domain\UseCase\CalculateUserTotalDaysEntries;
use ExpenseManagement\Domain\Exception\ManageUserExpenseFailedException;

class CalculateUserTotalDaysEntriesTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_add_expense_class()
    {
        $userId = '';

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $this->assertInstanceOf(CalculateUserTotalDaysEntries::class, new CalculateUserTotalDaysEntries($userId, $expenseRepository));
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_user_id_is_empty()
    {
        $this->expectException(ManageUserExpenseFailedException::class);
        $this->expectExceptionCode(ManageUserExpenseFailedException::USER_ID_IS_EMPTY);

        $userId = '';

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $calculateUsertotalDaysEntries = new CalculateUserTotalDaysEntries($userId, $expenseRepository);
        $calculateUsertotalDaysEntries->validate();
    }

    /**
     * @test
     */
    public function it_should_perform_calculate_user_total_days_entries()
    {
        $userId = 'fhqwer1o5';

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $expenseRepository->shouldReceive('getUserTotalDaysEntries')
                          ->andReturn(5);

        $calculateUsertotalDaysEntries = new CalculateUserTotalDaysEntries($userId, $expenseRepository);
        
        $this->assertEquals(5, $calculateUsertotalDaysEntries->perform());
    }
}
