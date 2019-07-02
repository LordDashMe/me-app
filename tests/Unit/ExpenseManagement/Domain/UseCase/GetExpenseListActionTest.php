<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use AppCommon\Domain\Message\DataTable;

use ExpenseManagement\Domain\Repository\ExpenseListRepository;
use ExpenseManagement\Domain\UseCase\GetExpenseListAction;

class GetExpenseListActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new GetExpenseListAction(
            Mockery::mock(DataTable::class),
            Mockery::mock(ExpenseListRepository::class)
        );

        $this->assertInstanceOf(GetExpenseListAction::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_get_expense_list()
    {
        $dataTable = new DataTable(0, 10, 'id', 'DESC');

        $expenseListRepository = Mockery::mock(ExpenseListRepository::class);
        $expenseListRepository->shouldReceive('start');
        $expenseListRepository->shouldReceive('length');
        $expenseListRepository->shouldReceive('search');
        $expenseListRepository->shouldReceive('orderColumn');
        $expenseListRepository->shouldReceive('orderBy');
        $expenseListRepository->shouldReceive('get')
                              ->andReturn([
                                  'totalRecords' => 0,
                                  'totalRecordsFiltered' => 0,
                                  'data' => []
                              ]);

        $useCase = new GetExpenseListAction($dataTable, $expenseListRepository);

        $expectedResult = [
            'totalRecords' => 0,
            'totalRecordsFiltered' => 0,
            'data' => []
        ];

        $this->assertEquals($expectedResult, $useCase->perform());
    }
}
