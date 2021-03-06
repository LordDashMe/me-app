<?php

namespace ExpenseManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use UserManagement\Domain\ValueObject\UserId;

/**
 * @ORM\Entity
 * @ORM\Table(name="expenses")
 */
class CalculateUserTotalExpenses
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     * 
     * @ORM\Id
     * @ORM\Column(type="text", name="UserID")
     */
    private $userId;

    /**
     * @ORM\Column(type="float", name="Cost", scale=2)
     */
    private $cost;

    /**
     * @ORM\Column(type="string", name="DeletedAt")
     */
    private $deletedAt = '';

    public function __construct(UserId $userId) 
    {
        $this->userId = $userId->get();
    }

    public function userId(): string
    {
        return $this->userId;
    }
}
