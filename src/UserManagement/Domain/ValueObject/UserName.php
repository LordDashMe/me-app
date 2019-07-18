<?php

namespace UserManagement\Domain\ValueObject;

use UserManagement\Domain\Exception\UserNameException;

class UserName
{
    const MAX_CHARACTER_LENGTH = 255;

    private $userName;
    
    public function __construct(string $userName)
    {
        $this->userName = $userName;

        $this->validateCharacterMaxLength();
    }

    private function validateCharacterMaxLength()
    {
        if (\strlen($this->userName) > self::MAX_CHARACTER_LENGTH) {
            throw UserNameException::exceededTheMaxCharacterLength();
        }
    }

    public function get()
    {
        return $this->userName;
    }
}
