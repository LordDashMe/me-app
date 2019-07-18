<?php

namespace ExpenseManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\ValueObject\ExpenseId;

/**
 * @ORM\Entity
 * @ORM\Table(name="expenses")
 */
class ExpenseDeletion
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     * 
     * @ORM\Id
     * @ORM\Column(type="text", name="ID", unique=true)
     */
    private $id;

    /**
     * @var \Ramsey\Uuid\UuidInterface
     * 
     * @ORM\Column(type="text", name="UserID")
     */
    private $userId;

    /**
     * @ORM\Column(type="string", name="DeletedAt")
     */
    private $deletedAt;

    public function __construct(ExpenseId $expenseId, UserId $userId) 
    {
        $this->id = $expenseId->get();
        $this->userId = $userId->get();
    }

    public function id(): string
    {
        return $this->id;
    }

    public function userId(): string
    {
        return $this->userId;
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
