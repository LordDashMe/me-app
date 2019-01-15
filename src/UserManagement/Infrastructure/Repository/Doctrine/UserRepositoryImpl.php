<?php

namespace UserManagement\Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\Repository\UserRepository;

class UserRepositoryImpl extends EntityRepository implements UserRepository
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

    public function update($id, User $user)
    {

    }

    public function get($id)
    {

    }

    public function softDelete($id)
    {

    }

    public function isApproved()
    {

    }

    public function isRegistered()
    {
        
    }
}
