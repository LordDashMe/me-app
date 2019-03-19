<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use DomainCommon\Domain\Exception\RequiredFieldException;
use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\UseCase\EditExpense;
use ExpenseManagement\Domain\Repository\ExpenseRepository;
use ExpenseManagement\Domain\Exception\ManageUserExpenseFailedException;

class EditExpenseTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_edit_expense_class()
    {
        $expenseId = '';
        $userId = '';

        $editExpenseData = [
            'label' => '',
            'cost' => '',
            'date' => ''
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $this->assertInstanceOf(EditExpense::class, new EditExpense($expenseId, $userId, $editExpenseData, $expenseRepository));
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_expense_id_is_empty()
    {
        $this->expectException(ManageUserExpenseFailedException::class);
        $this->expectExceptionCode(ManageUserExpenseFailedException::EXPENSE_ID_IS_EMPTY);

        $expenseId = '';
        $userId = 'fhqwer1o5';

        $editExpenseData = [
            'label' => '',
            'cost' => '',
            'date' => ''
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $editExpense = new EditExpense($expenseId, $userId, $editExpenseData, $expenseRepository);
        $editExpense->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_user_id_is_empty()
    {
        $this->expectException(ManageUserExpenseFailedException::class);
        $this->expectExceptionCode(ManageUserExpenseFailedException::USER_ID_IS_EMPTY);

        $expenseId = '1hqterrf5';
        $userId = '';

        $editExpenseData = [
            'label' => '',
            'cost' => '',
            'date' => ''
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $editExpense = new EditExpense($expenseId, $userId, $editExpenseData, $expenseRepository);
        $editExpense->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_required_field_is_empty()
    {
        $this->expectException(RequiredFieldException::class);
        $this->expectExceptionCode(RequiredFieldException::REQUIRED_FIELD_IS_EMPTY);

        $expenseId = '1hqterrf5';
        $userId = 'fhqwer1o5';

        $editExpenseData = [
            'label' => '',
            'cost' => '',
            'date' => ''
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $editExpense = new EditExpense($expenseId, $userId, $editExpenseData, $expenseRepository);
        $editExpense->validate();
    }

    /**
     * @test
     */
    public function it_should_perform_edit_expense()
    {
        $expenseId = '1hqterrf5';
        $userId = 'fhqwer1o5';

        $editExpenseData = [
            'label' => 'Coffee',
            'cost' => '5',
            'date' => '2019-03-19'
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $expenseRepository->shouldReceive('update')
                          ->andReturn(true);

        $editExpense = new EditExpense($expenseId, $userId, $editExpenseData, $expenseRepository);
        $editExpense->validate();
        
        $this->assertEquals(null, $editExpense->perform());
    }
}
