<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use ExpenseManagement\Domain\Message\EditExpenseData;
use ExpenseManagement\Domain\Repository\ExpenseModificationRepository;
use ExpenseManagement\Domain\UseCase\EditExpenseAction;
use ExpenseManagement\Domain\ValueObject\ExpenseId;

class EditExpenseActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new EditExpenseAction(
            Mockery::mock(EditExpenseData::class),
            Mockery::mock(ExpenseModificationRepository::class)
        );

        $this->assertInstanceOf(EditExpenseAction::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_edit_expense()
    {
        $expenseId = new ExpenseId('E-UUID001');

        $editExpenseData = new EditExpenseData(
            $expenseId->get(),
            'UUID001', 
            '4', 
            'Brewed Coffee with Cream', 
            22, 
            '2019-07-01'
        );

        $expenseModificationRepository = Mockery::mock(ExpenseModificationRepository::class);
        $expenseModificationRepository->shouldReceive('save')
                                      ->andReturn($expenseId);

        $useCase = new EditExpenseAction($editExpenseData, $expenseModificationRepository);
        
        $this->assertEquals($expenseId, $useCase->perform());
    }
}
