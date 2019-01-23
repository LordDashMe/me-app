<?php

namespace UserManagement\Domain\Service;

interface UserSessionManager
{
    public function getUserEntityAttributeName();

    public function set($attribute, $value);

    public function get($attribute);

    public function forget();
}
