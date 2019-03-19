<?php

namespace UserManagement\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\Repository\UserRepository;

class UserRepositoryImpl implements UserRepository
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function update(User $user)
    {

    }

    public function get(UserId $id)
    {

    }

    public function getDataTable($options) 
    {
        
    }

    public function softDelete(UserId $id)
    {

    }

    public function getByUsername(Username $username)
    {
        $criteria = ['username' => $username->get()];

        $repository = $this->entityManager->getRepository(User::class);
        
        return $repository->findOneBy($criteria);
    }

    public function isApproved(Username $username)
    {
        $criteria = [
            'username' => $username->get(),
            'status' => User::STATUS_ACTIVE
        ];

        $repository = $this->entityManager->getRepository(User::class);
        
        $userRecord = $repository->findOneBy($criteria);

        return (count($userRecord) > 0);
    }

    public function isRegistered(Username $username)
    {
        $criteria = ['username' => $username->get()];

        $repository = $this->entityManager->getRepository(User::class);
        
        $userRecord = $repository->findOneBy($criteria);

        return (count($userRecord) > 0);
    }
}
