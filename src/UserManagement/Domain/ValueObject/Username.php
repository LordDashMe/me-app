<?php

namespace UserManagement\Domain\ValueObject;

class Username
{
    const MAX_CHARACTER_LENGTH = 255;

    private $username;
    
    public function __construct($username = '')
    {
        $this->username = $username;
    }

    public function isValidCharacterMaxLength()
    {
        return (\strlen($this->username) === self::MAX_CHARACTER_LENGTH);
    }

    public function get()
    {
        return $this->username;
    }
}
