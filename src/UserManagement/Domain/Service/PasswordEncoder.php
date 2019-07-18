<?php

namespace UserManagement\Domain\Service;

interface PasswordEncoder
{
    public function encodePlainText(string $plainText): string;

    public function verifyEncodedText(string $encodedText, string $plainText): bool;
}
