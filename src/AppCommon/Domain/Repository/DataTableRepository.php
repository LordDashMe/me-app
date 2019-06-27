<?php

namespace AppCommon\Domain\Repository;

interface DataTableRepository
{
    public function start(int $start): void;

    public function length(int $length): void;

    public function search(string $length): void;

    public function orderColumn(string $orderColumn): void;

    public function orderBy(string $orderBy): void;

    public function get(): array;
}
