<?php

namespace UserManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use UserManagement\Domain\Entity\UserRegistration;
use UserManagement\Domain\Repository\UserRegistrationRepository;

class UserRegistrationRepositoryImpl implements UserRegistrationRepository
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function isUserNameAlreadyRegistered(UserRegistration $userRegistration): bool 
    {
        $criteria = [
            'deletedAt' => '',
            'userName' => $userRegistration->userName(),
        ];

        $repository = $this->entityManager->getRepository(UserRegistration::class);
        
        $record = $repository->findOneBy($criteria);

        return ($record === null ? false : true);      
    }

    public function save(UserRegistration $userRegistration): void
    {
        $this->entityManager->persist($userRegistration);
        $this->entityManager->flush();
    }
}
