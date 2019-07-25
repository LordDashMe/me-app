<?php

namespace UserManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use UserManagement\Domain\Entity\UserDeletion;
use UserManagement\Domain\Repository\UserDeletionRepository;
use UserManagement\Domain\ValueObject\UserId;

class UserDeletionRepositoryImpl implements UserDeletionRepository
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(UserDeletion $userDeletion): UserId
    {
        $this->entityManager->merge($userDeletion);
        $this->entityManager->flush();

        return new UserId($userDeletion->id());
    }
}
