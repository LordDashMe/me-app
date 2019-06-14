<?php

namespace DomainCommon\Domain\ValueObject;

class DataTable
{
    private $start = 0;
    private $length = 0;
    private $search = '';
    private $orderColumn = 'id';
    private $orderBy = 'DESC';

    public function setStart(int $start)
    {
        $this->start = $start;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setLength(int $length)
    {
        $this->length = $length;
    }

    public function getLength()
    {
        return $this->length;
    }

    public function setSearch(string $search)
    {
        $this->search = $search;
    }

    public function getSearch()
    {
        return $this->search;
    }

    public function setOrderColumn(string $orderColumn)
    {
        $this->orderColumn = $orderColumn;
    }

    public function getOrderColumn()
    {
        return $this->orderColumn;
    }

    public function setOrderBy(string $orderBy)
    {
        $this->orderBy = $orderBy;
    }

    public function getOrderBy()
    {
        return $this->orderBy;
    }
}
