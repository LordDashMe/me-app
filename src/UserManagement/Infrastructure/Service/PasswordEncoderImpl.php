<?php

namespace UserManagement\Infrastructure\Service;

use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use UserManagement\Domain\Service\PasswordEncoder;

class PasswordEncoderImpl extends BCryptPasswordEncoder implements PasswordEncoder
{
    const ENCODER_COST = 8;
    const DEFAULT_SALT = 'secret';

    public function __construct()
    {
        parent::__construct(self::ENCODER_COST);
    }

    public function encodePlainText($plainText)
    {
        return $this->encodePassword($plainText, self::DEFAULT_SALT);
    }

    public function verifyEncodedText($encodedText, $plainText)
    {
        return $this->isPasswordValid($encodedText, $plainText, self::DEFAULT_SALT);
    }
}
