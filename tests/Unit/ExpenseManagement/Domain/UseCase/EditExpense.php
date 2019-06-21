<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use DomainCommon\Domain\ValueObject\CreatedAt;
use DomainCommon\Domain\Exception\RequiredFieldException;
use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\Entity\Expense;
use ExpenseManagement\Domain\ValueObject\Cost;
use ExpenseManagement\Domain\ValueObject\Date;
use ExpenseManagement\Domain\ValueObject\Label;
use ExpenseManagement\Domain\UseCase\EditExpense;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
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

        $editExpenseData = [
            'label' => '',
            'cost' => '',
            'date' => ''
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $this->assertInstanceOf(EditExpense::class, new EditExpense($expenseId, $editExpenseData, $expenseRepository));
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_expense_id_is_empty()
    {
        $this->expectException(ManageUserExpenseFailedException::class);
        $this->expectExceptionCode(ManageUserExpenseFailedException::EXPENSE_ID_IS_EMPTY);

        $expenseId = '';

        $editExpenseData = [
            'label' => '',
            'cost' => '',
            'date' => ''
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $editExpense = new EditExpense($expenseId, $editExpenseData, $expenseRepository);
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

        $editExpenseData = [
            'label' => '',
            'cost' => '',
            'date' => ''
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $editExpense = new EditExpense($expenseId, $editExpenseData, $expenseRepository);
        $editExpense->validate();
    }

    /**
     * @test
     */
    public function it_should_perform_edit_expense()
    {
        $expenseId = '1hqterrf5';

        $editExpenseData = [
            'label' => 'Coffee',
            'cost' => '5',
            'date' => '2019-03-19'
        ];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $expenseRepository->shouldReceive('get')
                          ->andReturn($this->mockExpenseEntity());

        $expenseRepository->shouldReceive('update')
                          ->andReturn(true);

        $editExpense = new EditExpense($expenseId, $editExpenseData, $expenseRepository);
        $editExpense->validate();
        
        $this->assertEquals(null, $editExpense->perform());
    }

    private function mockExpenseEntity()
    {
        return new Expense(
            new ExpenseId('1hqterrf5'),
            new UserId('fhqwer1o5'),
            new Label('Coffee'),
            new Cost('10'),
            new Date('2019-03-19'),
            new CreatedAt
        );
    }
}
