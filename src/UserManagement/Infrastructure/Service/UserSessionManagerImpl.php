<?php

namespace UserManagement\Infrastructure\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserManagement\Domain\Service\UserSessionManager;

class UserSessionManagerImpl implements UserSessionManager
{
    const USER_ENTITY_SESSION_NAME = 'sessionUserEntity';

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getUserEntitySessionName(): string
    {
        return self::USER_ENTITY_SESSION_NAME;
    }

    public function set(string $attribute, string $value): void
    {
        $this->session->set($attribute, $value);
    }

    public function get($attribute)
    {
        return $this->session->get($attribute);
    }

    public function forget(): void
    {
        $this->session->clear();
    }

    public function isUserSessionAvailable(): bool
    {
        return (! empty($this->get($this->getUserEntitySessionName())));
    }
}
