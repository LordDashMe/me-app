<?php

namespace ExpenseManagement\Domain\Message;

use AppCommon\Domain\Message\DataTable;

class ExpenseDataTable extends DataTable
{
    public $userId;
    public $start;
    public $length;
    public $search;
    public $orderColumn;
    public $orderBy;

    public function __construct(
        string $userId = '',
        int $start = 0,
        int $length = 0,
        string $search = '',
        string $orderColumn = 'id',
        string $orderBy = 'DESC'
    ) {
        $this->userId = $userId;
        $this->start = $start;
        $this->length = $length;
        $this->search = $search;
        $this->orderColumn = $orderColumn;
        $this->orderBy = $orderBy;
    }
}
