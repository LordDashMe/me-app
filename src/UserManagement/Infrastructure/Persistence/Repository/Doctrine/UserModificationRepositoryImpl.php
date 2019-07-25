<?php

namespace UserManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use UserManagement\Domain\Entity\UserModification;
use UserManagement\Domain\Repository\UserModificationRepository;
use UserManagement\Domain\ValueObject\UserId;

class UserModificationRepositoryImpl implements UserModificationRepository
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(UserModification $userModification): UserId
    {
        $this->entityManager->merge($userModification);
        $this->entityManager->flush();

        return new UserId($userModification->id());
    }
}
