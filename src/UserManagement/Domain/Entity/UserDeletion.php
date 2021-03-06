<?php

namespace UserManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\ValueObject\UserId;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class UserDeletion
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     * 
     * @ORM\Id
     * @ORM\Column(type="string", length=255, name="ID", unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="DeletedAt")
     */
    private $deletedAt = '';

    public function __construct(UserId $userId)
    {
        $this->id = $userId->get();
    }

    public function id(): string 
    {
        return $this->id;
    }

    public function deletedAt(): string
    {
        return $this->deletedAt;
    }
    
    public function softDelete(CreatedAt $deletedAt): void
    {
        $this->deletedAt = $deletedAt->get();
    }
}
