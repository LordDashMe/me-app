<?php

namespace ExpenseManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use AppCommon\Infrastructure\Persistence\Repository\Doctrine\DataTableRepositoryImpl;

use ExpenseManagement\Domain\Entity\Model\Expense;
use ExpenseManagement\Domain\Repository\ExpenseListRepository;

class ExpenseListRepositoryImpl extends DataTableRepositoryImpl implements ExpenseListRepository
{
    protected $tableDefinition = [
        [
            'db_name' => 'id',
            'app_name' => 'id',
            'search' => false
        ],
        [
            'db_name' => 'type',
            'app_name' => 'type',
            'search' => true
        ],
        [
            'db_name' => 'label',
            'app_name' => 'label',
            'search' => true
        ],
        [
            'db_name' => 'cost',
            'app_name' => 'cost',
            'search' => true
        ],
        [
            'db_name' => 'date',
            'app_name' => 'date',
            'search' => true
        ],
        [
            'db_name' => 'id',
            'app_name' => 'action',
            'search' => false
        ]
    ];

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public function entityNamespace(): string 
    {
        return Expense::class;
    }
}
