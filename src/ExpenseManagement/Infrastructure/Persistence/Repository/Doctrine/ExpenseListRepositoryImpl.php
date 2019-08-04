<?php

namespace ExpenseManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use AppCommon\Infrastructure\Persistence\Repository\Doctrine\DataTableRepositoryImpl;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\Entity\Model\Expense;
use ExpenseManagement\Domain\Repository\ExpenseListRepository;

class ExpenseListRepositoryImpl extends DataTableRepositoryImpl implements ExpenseListRepository
{
    private $userId;

    protected $tableDefinition = [
        [
            'db_name' => 'id',
            'app_name' => 'action',
            'search' => false
        ],
        [
            'db_name' => 'id',
            'app_name' => 'id',
            'search' => false
        ],
        [
            'db_name' => 'type',
            'app_name' => 'type',
            'search' => false
        ],
        [
            'db_name' => 'label',
            'app_name' => 'label',
            'search' => true
        ],
        [
            'db_name' => 'cost',
            'app_name' => 'cost',
            'search' => false
        ],
        [
            'db_name' => 'date',
            'app_name' => 'date',
            'search' => true
        ],
        [
            'db_name' => 'createdAt',
            'app_name' => 'created_at',
            'search' => true
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

    public function setUserId(UserId $userId): void 
    {
        $this->userId = $userId;
    }

    protected function customCondition($queryBuilder)
    {
        $queryBuilder->andWhere('u.userId = :userId');
        $queryBuilder->setParameter('userId', $this->userId->get());

        return $queryBuilder;
    }
}
