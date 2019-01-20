<?php

namespace UserManagement\Presentation\EventSubscriber;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Psr\Container\ContainerInterface;

class TokenSubscriber implements EventSubscriberInterface
{
    private $session;
    private $container;
    
    public function __construct(ContainerInterface $container,SessionInterface $session)
    {
        $this->session = $session;
        $this->container = $container;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        var_dump($this->session->get('user'));

        if ($controller[0] instanceof \UserManagement\Presentation\Controller\Security\AuthenticatedController) {

            if (! $this->session->get('user')) {
                $url = $this->container->get('router')
                    ->generate('user_management_login', array(), UrlGeneratorInterface::ABSOLUTE_PATH);

                $event->setController(function() use ($url) {
                    return new RedirectResponse($url);
                });
            }
        }

        if ($controller[0] instanceof \UserManagement\Presentation\Controller\Security\UnauthenticatedController) {
            if ($this->session->get('user')) {
                $url = $this->container->get('router')
                    ->generate('user_management_home', array(), UrlGeneratorInterface::ABSOLUTE_PATH);

                $event->setController(function() use ($url) {
                    return new RedirectResponse($url);
                });
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
