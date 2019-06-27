<?php

namespace UserManagement\Infrastructure\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

use AppCommon\Domain\ValueObject\CreatedAt;
use AppCommon\Domain\ValueObject\DataTable;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\Repository\UserRepository;

class UserRepositoryImpl implements UserRepository
{
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function update(User $user): void
    {
        $this->entityManager->merge($user);
        $this->entityManager->flush();
    }

    public function get(UserId $id)
    {
        $entityPropertyCriteria = [
            'deletedAt' => '',
            'id' => $id->get()
        ];
        
        $userEntity = $this->entityManager->getRepository(User::class)->findBy($entityPropertyCriteria);
        
        return $userEntity[0];
    }

    public function getDataTable(DataTable $userDataTable): array
    {
        $total = $this->entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('COUNT(u.ID)')
            ->getQuery()
            ->getSingleScalarResult();

        $queryBuilder = $this->entityManager->getRepository(User::class)->createQueryBuilder('u');
        $queryBuilder->where("u.DeletedAt = ''");
        $queryBuilder->andWhere("u.ID LIKE :id OR u.FirstName LIKE :firstName OR u.LastName LIKE :lastName");
        $queryBuilder->setParameter('id', "%{$userDataTable->getSearch()}%");
        $queryBuilder->setParameter('firstName', "%{$userDataTable->getSearch()}%");
        $queryBuilder->setParameter('lastName', "%{$userDataTable->getSearch()}%");
        $queryBuilder->orderBy("u.{$userDataTable->getOrderColumn()}", \strtoupper($userDataTable->getOrderBy()));
        
        if ($userDataTable->getLength() > 0) {
            $queryBuilder->setMaxResults($userDataTable->getLength());
        }
        
        $queryBuilder->setFirstResult($userDataTable->getStart());
        
        $data = $queryBuilder->getQuery()->getResult();
        
        return [
            'totalRecords' => $total,
            'totalRecordsFiltered' => \count($data),
            'data' => $data
        ];   
    }

    public function softDelete(UserId $id): string
    {
        $userEntity = $this->entityManager->getRepository(User::class)->findBy(['id' => $id->get()]);

        $userEntity[0]->setDeletedAt((new CreatedAt())->get());

        $this->entityManager->flush();

        return $id->get();
    }

    public function getByUserName(UserName $userName)
    {
        $entityPropertyCriteria = [
            'deletedAt' => '',
            'userName' => $userName->get()
        ];

        $repository = $this->entityManager->getRepository(User::class);
        
        return $repository->findOneBy($entityPropertyCriteria);
    }

    public function isApproved(UserName $userName): bool
    {
        $entityPropertyCriteria = [
            'deletedAt' => '',
            'userName' => $userName->get(),
            'status' => User::STATUS_ACTIVE
        ];

        $repository = $this->entityManager->getRepository(User::class);
        
        $userRecord = $repository->findOneBy($entityPropertyCriteria);

        return (\count($userRecord) > 0);
    }

    public function isRegistered(UserName $userName): bool
    {
        $entityPropertyCriteria = [
            'deletedAt' => '',
            'userName' => $userName->get(),
        ];

        $repository = $this->entityManager->getRepository(User::class);
        
        $userRecord = $repository->findOneBy($entityPropertyCriteria);

        return (\count($userRecord) > 0);
    }
}
