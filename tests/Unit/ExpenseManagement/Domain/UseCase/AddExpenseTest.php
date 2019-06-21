<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use DomainCommon\Domain\Exception\RequiredFieldException;
use DomainCommon\Domain\Service\UniqueIDResolver;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\DataTransferObject\ExpenseData;
use ExpenseManagement\Domain\Repository\ExpenseRepository;
use ExpenseManagement\Domain\Exception\ManageUserExpenseFailedException;
use ExpenseManagement\Domain\UseCase\AddExpense;
use ExpenseManagement\Domain\ValueObject\Cost;
use ExpenseManagement\Domain\ValueObject\Date;
use ExpenseManagement\Domain\ValueObject\Label;
use ExpenseManagement\Domain\ValueObject\ExpenseId;

class AddExpenseTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_main_class()
    {
        $userId = new UserId('');

        $expenseData = Mockery::mock(ExpenseData::class);
        $expenseRepository = Mockery::mock(ExpenseRepository::class);
        $uniqueIDResolver = Mockery::mock(UniqueIDResolver::class);

        $useCase = new AddExpense($userId, $expenseData, $expenseRepository, $uniqueIDResolver);

        $this->assertInstanceOf(AddExpense::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_user_id_is_empty()
    {
        $this->expectException(ManageUserExpenseFailedException::class);
        $this->expectExceptionCode(ManageUserExpenseFailedException::USER_ID_IS_EMPTY);

        $userId = new UserId('');

        $expenseData = new ExpenseData(
            new Label(''),
            new Cost(''),
            new Date('')
        );

        $expenseRepository = Mockery::mock(ExpenseRepository::class);
        $uniqueIDResolver = Mockery::mock(UniqueIDResolver::class);

        $addExpense = new AddExpense($userId, $expenseData, $expenseRepository, $uniqueIDResolver);
        $addExpense->validate();
    }

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
