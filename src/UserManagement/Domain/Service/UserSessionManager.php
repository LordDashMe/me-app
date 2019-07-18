<?php

namespace UserManagement\Domain\Service;

interface UserSessionManager
{
    public function set($value): void;

    public function get();

    public function forget(): void;

    public function isUserSessionAvailable(): bool;
}
