<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use ExpenseManagement\Domain\Message\DeleteExpenseData;
use ExpenseManagement\Domain\Repository\ExpenseDeletionRepository;
use ExpenseManagement\Domain\UseCase\DeleteExpenseAction;

class DeleteExpenseActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new DeleteExpenseAction(
            Mockery::mock(DeleteExpenseData::class), 
            Mockery::mock(ExpenseDeletionRepository::class)
        );

        $this->assertInstanceOf(DeleteExpenseAction::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_delete_expense()
    {
        $deleteExpenseData = new DeleteExpenseData(
            'E-UUID001',
            'UUID001'
        );

        $expenseDeletionRepository = Mockery::mock(ExpenseDeletionRepository::class);
        $expenseDeletionRepository->shouldReceive('save')
                                  ->andReturn($deleteExpenseData->expenseId);

        $useCase = new DeleteExpenseAction(
            $deleteExpenseData, 
            $expenseDeletionRepository
        );
        
        $this->assertEquals($deleteExpenseData->expenseId, $useCase->perform());
    }
}
