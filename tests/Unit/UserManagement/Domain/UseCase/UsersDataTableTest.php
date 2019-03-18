<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use UserManagement\Domain\UseCase\UsersDataTable;
use UserManagement\Domain\Repository\UserRepository;

class UsersDataTableTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_users_data_table_class()
    {
        $usersDataTableData = [];

        $userRepository = Mockery::mock(UserRepository::class);

        $this->assertInstanceOf(UsersDataTable::class, new UsersDataTable($usersDataTableData, $userRepository));
    }

    /**
     * @test
     */
    public function it_should_perform_users_data_table()
    {
        $usersDataTableData = [
            'start' => 0,
            'length' => 10,
            'search' => '',
            'order_column' => 'id',
            'order_by' => 'DESC'
        ];
        $userRepository = Mockery::mock(UserRepository::class);

        $userRepository->shouldReceive('getDataTable')
                       ->andReturn([
                           'total_records' => 0,
                           'total_records_filtered' => 0,
                           'data' => []
                       ]);

        $usersDataTable = new UsersDataTable($usersDataTableData, $userRepository);

        $this->assertEquals([
            'total_records' => 0,
            'total_records_filtered' => 0,
            'data' => []
        ], $usersDataTable->perform());
    }
}
