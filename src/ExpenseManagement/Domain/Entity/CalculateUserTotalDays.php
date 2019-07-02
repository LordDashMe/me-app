<?php

namespace ExpenseManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use UserManagement\Domain\ValueObject\UserId;

/**
 * @ORM\Entity
 * @ORM\Table(name="expenses")
 */
class CalculateUserTotalDays
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     * 
     * @ORM\Column(type="text", name="ID", unique=true)
     */
    private $id;

    /**
     * @var \Ramsey\Uuid\UuidInterface
     * 
     * @ORM\Column(type="text", name="UserID")
     */
    private $userId;

    public function __construct(UserId $userId) 
    {
        $this->userId = $userId;
    }

    public function userId(): string
    {
        return $this->userId;
    }
}
