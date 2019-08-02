<?php

namespace UserManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use AppCommon\Infrastructure\Persistence\Repository\Doctrine\DataTableRepositoryImpl;

use UserManagement\Domain\Entity\Model\User;
use UserManagement\Domain\Repository\UserListRepository;

class UserListRepositoryImpl extends DataTableRepositoryImpl implements UserListRepository
{
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
            'db_name' => 'firstName',
            'app_name' => 'first_name',
            'search' => true
        ],
        [
            'db_name' => 'lastName',
            'app_name' => 'last_name',
            'search' => true
        ],
        [
            'db_name' => 'email',
            'app_name' => 'email',
            'search' => true
        ],
        [
            'db_name' => 'status',
            'app_name' => 'status',
            'search' => true
        ]
    ];

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager);
    }

    public function entityNamespace(): string 
    {
        return User::class;
    }
}
