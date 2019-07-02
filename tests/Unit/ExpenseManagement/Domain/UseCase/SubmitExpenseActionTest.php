<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use AppCommon\Domain\Service\UniqueIDResolver;

use ExpenseManagement\Domain\Message\SubmitExpenseData;
use ExpenseManagement\Domain\Repository\SubmitExpenseRepository;
use ExpenseManagement\Domain\UseCase\SubmitExpenseAction;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\ValueObject\Type;
use ExpenseManagement\Domain\ValueObject\Label;
use ExpenseManagement\Domain\ValueObject\Cost;
use ExpenseManagement\Domain\ValueObject\Date;

class SubmitExpenseTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_main_class()
    {
        $useCase = new SubmitExpenseAction(
            Mockery::mock(SubmitExpenseData::class), 
            Mockery::mock(SubmitExpenseRepository::class),
            Mockery::mock(UniqueIDResolver::class)
        );

        $this->assertInstanceOf(SubmitExpenseAction::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_add_expense()
    {
        $submitExpenseData = new SubmitExpenseData('UUID001', '4', 'Brewed Coffee', 22, '2019-07-01');

        $submitExpenseRepository = Mockery::mock(SubmitExpenseRepository::class);
        $submitExpenseRepository->shouldReceive('save')
                                ->andReturn(true);

        $uniqueIDResolver = Mockery::mock(UniqueIDResolver::class);
        $uniqueIDResolver->shouldReceive('generate')
                         ->andReturn('UUID001');

        $useCase = new SubmitExpenseAction(
            $submitExpenseData, 
            $submitExpenseRepository,
            $uniqueIDResolver
        );
        
        $this->assertEquals(null, $useCase->perform());
    }
}
