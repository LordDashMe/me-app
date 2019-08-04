<?php

namespace UserManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use UserManagement\Domain\Entity\Model\User;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\UserName;

class UserRepositoryImpl implements UserRepository
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getById(UserId $userId)
    {
        $criteria = [
            'deletedAt' => '',
            'id' => $userId->get()
        ];
        
        $repository = $this->entityManager->getRepository(User::class);

        $record = $repository->findOneBy($criteria);
        
        return $record === null ? false : $record;
    }

    public function getByUserName(UserName $userName)
    {
        $criteria = [
            'deletedAt' => '',
            'userName' => $userName->get()
        ];
        
        $repository = $this->entityManager->getRepository(User::class);

        $record = $repository->findOneBy($criteria);
        
        return $record === null ? false : $record;
    }
}
