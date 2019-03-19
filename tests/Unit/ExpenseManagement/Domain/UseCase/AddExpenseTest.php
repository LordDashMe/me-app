<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use DomainCommon\Domain\Exception\RequiredFieldException;
use ExpenseManagement\Domain\UseCase\AddExpense;
use ExpenseManagement\Domain\Repository\ExpenseRepository;
use ExpenseManagement\Domain\Exception\ManageUserExpenseFailedException;

class AddExpenseTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_add_expense_class()
    {
        $userId = '';

        $addExpenseData = [
            'label' => '',
            'cost' => '',
            'date' => ''
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $this->assertInstanceOf(AddExpense::class, new AddExpense($userId, $addExpenseData, $expenseRepository));
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_user_id_is_empty()
    {
        $this->expectException(ManageUserExpenseFailedException::class);
        $this->expectExceptionCode(ManageUserExpenseFailedException::USER_ID_IS_EMPTY);

        $userId = '';

        $addExpenseData = [
            'label' => '',
            'cost' => '',
            'date' => ''
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $addExpense = new AddExpense($userId, $addExpenseData, $expenseRepository);
        $addExpense->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_required_field_is_empty()
    {
        $this->expectException(RequiredFieldException::class);
        $this->expectExceptionCode(RequiredFieldException::REQUIRED_FIELD_IS_EMPTY);

        $userId = 'fhqwer1o5';

        $addExpenseData = [
            'label' => '',
            'cost' => '',
            'date' => ''
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $addExpense = new AddExpense($userId, $addExpenseData, $expenseRepository);
        $addExpense->validate();
    }

    /**
     * @test
     */
    public function it_should_perform_add_expense()
    {
        $userId = 'fhqwer1o5';

        $addExpenseData = [
            'label' => 'Coffee',
            'cost' => '5',
            'date' => '2019-03-19'
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $expenseRepository->shouldReceive('create')
                          ->andReturn(true);

        $addExpense = new AddExpense($userId, $addExpenseData, $expenseRepository);
        $addExpense->validate();
        
        $this->assertEquals(null, $addExpense->perform());
    }
}
