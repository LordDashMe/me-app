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

    public function encodePlainText(string $plainText, string $salt): string
    {
        return $this->encoder->encodePassword($plainText, $salt);
    }

    public function verifyEncodedText(string $encodedText, string $plainText, string $salt): bool
    {
        return $this->encoder->isPasswordValid($encodedText, $plainText, $salt);
    }
}
