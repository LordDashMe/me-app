<?php

namespace UserManagement\Infrastructure\Service;

use Symfony\Component\Security\Core\Encoder\SelfSaltingEncoderInterface;
use UserManagement\Domain\Service\PasswordEncoder;

class PasswordEncoderImpl implements PasswordEncoder
{
    private $encoder;

    public function __construct(SelfSaltingEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function encodePlainText($plainText, $salt)
    {
        return $this->encoder->encodePassword($plainText, $salt);
    }

    public function verifyEncodedText($encodedText, $plainText, $salt)
    {
        return $this->encoder->isPasswordValid($encodedText, $plainText, $salt);
    }
}
