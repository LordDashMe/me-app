<?php

namespace UserManagement\Domain\ValueObject;

use UserManagement\Domain\Exception\EmailException;

class Email
{
    const MAX_CHARACTER_LENGTH = 255;

    private $email;
    
    public function __construct(string $email)
    {
        $this->email = $email;

        $this->validateFormat();
        $this->validateCharacterMaxLength();
    }

    private function validateFormat(): void
    {
        if (! \filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw EmailException::invalidFormat();
        }
    }

    private function validateCharacterMaxLength(): void
    {
        if (\strlen($this->email) > self::MAX_CHARACTER_LENGTH) {
            throw EmailException::exceededTheMaxCharacterLength();
        }
    }

    public function get()
    {
        return $this->email;
    }
}
