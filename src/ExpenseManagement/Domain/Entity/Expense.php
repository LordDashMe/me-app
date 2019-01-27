<?php

namespace ExpenseManagement\Domain\Entity;

use Doctrine\ORM\Mapping AS ORM;

use DomainCommon\Domain\ValueObject\CreatedAt;
use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\ValueObject\Label;
use ExpenseManagement\Domain\ValueObject\Cost;

/**
 * @ORM\Entity
 * @ORM\Table(name="expense")
 */
class Expense
{
    /**
     * @ORM\Id
     * @ORM\Column(type="guid")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $userId;

    /**
     * @ORM\Column(type="text")
     */
    private $label;

    /**
     * @ORM\Column(type="integer")
     */
    private $cost;

    /**
     * @ORM\Column(type="string")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $createdAt;

    public function __construct(
        ExpenseId $id,
        UserId $userId,
        Label $label,
        Cost $cost,
        Date $date,
        CreatedAt $createdAt
    ) {
        $this->id = $id->get();
        $this->userId = $userId->get();
        $this->label = $label->get();
        $this->cost = $cost->get();
        $this->date = $date->get();
        $this->createdAt = $createdAt->get();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getCreateAt()
    {
        return $this->createAt;
    }
}
