<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use ExpenseManagement\Domain\UseCase\DeleteExpense;
use ExpenseManagement\Domain\Repository\ExpenseRepository;

class DeleteExpenseTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_edit_expense_class()
    {
        $expenseId = '';
        $userId = '';

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $this->assertInstanceOf(DeleteExpense::class, new DeleteExpense($expenseId, $userId, $expenseRepository));
    }

    /**
     * @test
     */
    public function it_should_perform_delete_expense()
    {
        $expenseId = '1hqterrf5';
        $userId = 'fhqwer1o5';

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $expenseRepository->shouldReceive('softDelete')
                          ->andReturn(true);

        $deleteExpense = new DeleteExpense($expenseId, $userId, $expenseRepository);
        
        $this->assertTrue($deleteExpense->perform());
    }
}
