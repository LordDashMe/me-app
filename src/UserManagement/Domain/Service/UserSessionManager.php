<?php

namespace UserManagement\Domain\Service;

interface UserSessionManager
{
    public function getUserEntitySessionName(): string;

    public function set(string $attribute, $value): void;

    public function get(string $attribute);

    public function forget(): void;

    public function isUserSessionAvailable(): bool;
}
