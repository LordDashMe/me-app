<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use ExpenseManagement\Domain\UseCase\DeleteExpense;
use ExpenseManagement\Domain\Repository\ExpenseRepository;
use ExpenseManagement\Domain\Exception\ManageUserExpenseFailedException;

class DeleteExpenseTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_edit_expense_class()
    {
        $expenseId = '';

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $this->assertInstanceOf(DeleteExpense::class, new DeleteExpense($expenseId, $expenseRepository));
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_expense_id_is_empty()
    {
        $this->expectException(ManageUserExpenseFailedException::class);
        $this->expectExceptionCode(ManageUserExpenseFailedException::EXPENSE_ID_IS_EMPTY);

        $expenseId = '';

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $deleteExpense = new DeleteExpense($expenseId, $expenseRepository);
        $deleteExpense->validate();
    }

    /**
     * @test
     */
    public function it_should_perform_delete_expense()
    {
        $expenseId = '1hqterrf5';

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $expenseRepository->shouldReceive('softDelete')
                          ->andReturn(true);

        $deleteExpense = new DeleteExpense($expenseId, $expenseRepository);
        
        $this->assertTrue($deleteExpense->perform());
    }
}
