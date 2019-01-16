<?php

namespace UserManagement\Domain\ValueObject;

class Email
{
    const MAX_CHARACTER_LENGTH = 255;

    private $email;
    
    public function __construct($email = '')
    {
        $this->email = $email;
    }

    public function isValid()
    {
        return (\filter_var($this->email, FILTER_VALIDATE_EMAIL));
    }

    public function isValidCharacterMaxLength()
    {
        return (\strlen($this->email) === self::MAX_CHARACTER_LENGTH);
    }

    public function get()
    {
        return $this->email;
    }
}
