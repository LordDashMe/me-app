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

    public function set($value): void
    {
        $this->session->set(self::USER_ENTITY_SESSION_NAME, $value);
    }

    public function get()
    {
        return $this->session->get(self::USER_ENTITY_SESSION_NAME);
    }

    public function forget(): void
    {
        $this->session->clear();
    }

    public function isUserSessionAvailable(): bool
    {
        return (! empty($this->get()));
    }
}
