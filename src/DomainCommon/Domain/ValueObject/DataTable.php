<?php

namespace DomainCommon\Domain\ValueObject;

class DataTable
{
    private $start = 0;
    private $length = 0;
    private $search = '';
    private $orderColumn = 'id';
    private $orderBy = 'DESC';

    public function setStart(int $start): void
    {
        $this->start = $start;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function setLength(int $length): void
    {
        $this->length = $length;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function setSearch(string $search): void
    {
        $this->search = $search;
    }

    public function getSearch(): string
    {
        return $this->search;
    }

    public function setOrderColumn(string $orderColumn): void
    {
        $this->orderColumn = $orderColumn;
    }

    public function getOrderColumn(): string
    {
        return $this->orderColumn;
    }

    public function setOrderBy(string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    public function getOrderBy(): string
    {
        return $this->orderBy;
    }
}
