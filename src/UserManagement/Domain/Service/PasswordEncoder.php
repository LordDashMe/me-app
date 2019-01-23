<?php

namespace UserManagement\Domain\Service;

interface PasswordEncoder
{
    public function encodePlainText($plainText, $salt);

    public function verifyEncodedText($encodedText, $plainText, $salt);
}
