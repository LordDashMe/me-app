<?php

namespace UserManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use UserManagement\Domain\Entity\UserLogin;
use UserManagement\Domain\Repository\UserLoginRepository;

class UserLoginRepositoryImpl implements UserLoginRepository
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get(UserLogin $userLogin)
    {
        $criteria = [
            'deletedAt' => '',
            'userName' => $userLogin->userName()
        ];
        
        $repository = $this->entityManager->getRepository(UserLogin::class);

        $record = $repository->findOneBy($criteria);
        
        return $record === null ? false : $record;
    }
}
