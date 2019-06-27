<?php

namespace AppCommon\Domain\Message;

class DataTable
{
    public $start;
    public $length;
    public $search;
    public $orderColumn;
    public $orderBy;

    public function __construct(
        int $start = 0,
        int $length = 0,
        string $search = '',
        string $orderColumn = 'id',
        string $orderBy = 'DESC'
    ) {
        $this->start = $start;
        $this->length = $length;
        $this->search = $search;
        $this->orderColumn = $orderColumn;
        $this->orderBy = $orderBy;
    }
}
