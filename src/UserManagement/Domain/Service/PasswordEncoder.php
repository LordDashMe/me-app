<?php

namespace UserManagement\Domain\Service;

interface PasswordEncoder
{
    public function encodePlainText($plainText);

    public function verifyEncodedText($encodedText, $plainText);
}
