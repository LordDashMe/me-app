<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\UseCase\ExpensesDataTable;
use ExpenseManagement\Domain\Repository\ExpenseRepository;

class ExpensesDataTableTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_expenses_data_table_class()
    {
        $userId = '';

        $dataTableRequestData = [];

        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $this->assertInstanceOf(ExpensesDataTable::class, new ExpensesDataTable($userId, $dataTableRequestData, $expenseRepository));
    }

    /**
     * @test
     */
    public function it_should_perform_expenses_data_table()
    {
        $userId = 'fhqwer1o5';

        $dataTableRequestData = [
            'start' => 0,
            'length' => 10,
            'search' => '',
            'orderColumn' => 'id',
            'orderBy' => 'DESC'
        ];
        
        $expenseRepository = Mockery::mock(ExpenseRepository::class);

        $expenseRepository->shouldReceive('getDataTable')
                        ->andReturn([
                            'totalRecords' => 0,
                            'totalRecordsFiltered' => 0,
                            'data' => []
                        ]);

        $expensesDataTable = new ExpensesDataTable($userId, $dataTableRequestData, $expenseRepository);

        $this->assertEquals([
            'totalRecords' => 0,
            'totalRecordsFiltered' => 0,
            'data' => []
        ], $expensesDataTable->perform());
    }
}
