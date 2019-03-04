<?php

namespace UserManagement\Domain\Service;

interface UserSessionManager
{
    public function getUserEntitySessionName();

    public function set($attribute, $value);

    public function get($attribute);

    public function forget();

    public function isUserSessionAvailable();
}
