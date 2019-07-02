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

    public function encodePlainText(string $plainText): string
    {
        return $this->encoder->encodePassword($plainText, uniqid());
    }

    public function verifyEncodedText(string $encodedText, string $plainText): bool
    {
        return $this->encoder->isPasswordValid($encodedText, $plainText, uniqid());
    }
}
