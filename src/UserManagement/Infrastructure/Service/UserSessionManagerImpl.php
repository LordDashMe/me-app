<?php

namespace UserManagement\Infrastructure\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserManagement\Domain\Service\UserSessionManager;

class UserSessionManagerImpl implements UserSessionManager
{
    const USER_ENTITY_SESSION_NAME = 'session_user_entity';

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getUserEntitySessionName()
    {
        return self::USER_ENTITY_SESSION_NAME;
    }

    public function set($attribute, $value)
    {
        $this->session->set($attribute, $value);
    }

    public function get($attribute)
    {
        return $this->session->get($attribute);
    }

    public function forget()
    {
        $this->session->clear();
    }

    public function isUserSessionAvailable()
    {
        return (! empty($this->get($this->getUserEntitySessionName())));
    }
}
