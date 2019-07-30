<?php

namespace ExpenseManagement\Domain\Entity\Model;

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
class Expense
{
    /**
     * @var \Ramsey\Uuid\UuidInterface
     * 
     * @ORM\Id
     * @ORM\Column(type="string", length=255, name="ID", unique=true)
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
     * @ORM\Column(type="string", name="CreatedAt")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", name="DeletedAt")
     */
    private $deletedAt;

    public function __construct(
        ExpenseId $id,
        UserId $userId,
        Type $type,
        Label $label,
        Cost $cost,
        Date $date,
        CreatedAt $createdAt
    ) {
        $this->id = $id->get();
        $this->userId = $userId->get();
        $this->type = $type->get();
        $this->label = $label->get();
        $this->cost = $cost->get();
        $this->date = $date->get();
        $this->createdAt = $createdAt->get();
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

    public function createdAt(): string
    {
        return $this->createdAt;
    }
}
