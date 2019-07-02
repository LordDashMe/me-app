<?php

namespace ExpenseManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\ValueObject\Type;
use ExpenseManagement\Domain\ValueObject\Label;
use ExpenseManagement\Domain\ValueObject\Cost;
use ExpenseManagement\Domain\ValueObject\Date;

/**
 * @ORM\Entity
 * @ORM\Table(name="expenses")
 */
class ExpenseModification
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

    /**
     * @ORM\Column(type="smallint", name="Type", options={"comment":"1 = Communication | 2 = Transportation | 3 = Representation | 4 = Sundries"})
     */
    private $type;

    /**
     * @ORM\Column(type="text", name="Label")
     */
    private $label;

    /**
     * @ORM\Column(type="float", name="Cost", scale=2)
     */
    private $cost;

    /**
     * @ORM\Column(type="string", name="Date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", name="DeletedAt")
     */
    private $deletedAt;

    public function __construct(ExpenseId $expenseId, UserId $userId) 
    {
        $this->id = $expenseId;
        $this->userId = $userId;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function label(): string
    {
        return $this->label;
    }

    public function cost(): float
    {
        return $this->cost;
    }

    public function date(): string
    {
        return $this->date;
    }

    public function changeType(Type $type): void 
    {
        $this->type = $type;
    }

    public function changeLabel(Label $label): void 
    {
        $this->label = $label;
    }

    public function changeCost(Cost $cost): void 
    {
        $this->cost = $cost;
    }

    public function changeDate(Date $date): void 
    {
        $this->date = $date;
    }

    public function delete(CreatedAt $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }
}
