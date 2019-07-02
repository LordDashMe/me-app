<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use ExpenseManagement\Domain\Message\EditExpenseData;
use ExpenseManagement\Domain\Repository\ExpenseModificationRepository;
use ExpenseManagement\Domain\UseCase\EditExpenseAction;

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
        $editExpenseData = new EditExpenseData(
            'E-UUID001',
            'UUID001', 
            '4', 
            'Brewed Coffee with Cream', 
            22, 
            '2019-07-01'
        );

        $expenseModificationRepository = Mockery::mock(ExpenseModificationRepository::class);
        $expenseModificationRepository->shouldReceive('save')
                                      ->andReturn(null);

        $useCase = new EditExpenseAction($editExpenseData, $expenseModificationRepository);
        
        $this->assertEquals(null, $useCase->perform());
    }
}
