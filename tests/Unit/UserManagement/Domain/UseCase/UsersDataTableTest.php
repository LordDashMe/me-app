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
    public function it_should_load_the_main_class()
    {
        $dataTableRequestData = [];

        $userRepository = Mockery::mock(UserRepository::class);

        $this->assertInstanceOf(UsersDataTable::class, new UsersDataTable($dataTableRequestData, $userRepository));
    }

    /**
     * @test
     */
    public function it_should_perform_users_data_table()
    {
        $dataTableRequestData = [
            'start' => 0,
            'length' => 10,
            'search' => '',
            'orderColumn' => 'id',
            'orderBy' => 'DESC'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);

        $userRepository->shouldReceive('getDataTable')
                       ->andReturn([
                           'totalRecords' => 0,
                           'totalRecordsFiltered' => 0,
                           'data' => []
                       ]);

        $usersDataTable = new UsersDataTable($dataTableRequestData, $userRepository);

        $this->assertEquals([
            'totalRecords' => 0,
            'totalRecordsFiltered' => 0,
            'data' => []
        ], $usersDataTable->perform());
    }
}
