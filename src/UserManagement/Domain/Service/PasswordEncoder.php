<?php

namespace UserManagement\Domain\Service;

interface PasswordEncoder
{
    public function encodePlainText($plainText, $salt): string;

    public function verifyEncodedText($encodedText, $plainText, $salt): bool;
}
