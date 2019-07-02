<?php

namespace UserManagement\Domain\Service;

interface PasswordEncoder
{
    public function encodePlainText($plainText): string;

    public function verifyEncodedText($encodedText, $plainText): bool;
}
