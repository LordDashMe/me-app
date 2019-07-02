<?php

namespace UserManagement\Application\EventSubscriber;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use UserManagement\Domain\Service\UserSessionManager;
use AppCommon\Application\Controller\Security\AuthenticatedController;
use AppCommon\Application\Controller\Security\UnauthenticatedController;

class AuthenticationSubscriber implements EventSubscriberInterface
{
    private $container;
    private $userSessionManager;
    
    public function __construct(ContainerInterface $container, UserSessionManager $userSessionManager)
    {
        $this->container = $container;
        $this->userSessionManager = $userSessionManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        /*
         * $controller passed can be either a class or a Closure.
         * This is not usual in Symfony but it may happen.
         * If it is a class, it comes in array format
         * 
         * - From Symfony
         */
        if (!is_array($controller)) {
            return;
        }

        $this->validateAuthenticatedController($controller, $event);
        $this->validateUnauthenticatedController($controller, $event);        
    }

    private function validateAuthenticatedController($controller, $event)
    {
        if (! $controller[0] instanceof AuthenticatedController) {
            return;
        }

        if (! $this->userSessionManager->isUserSessionAvailable()) {
            $url = $this->container->get('router')->generate(
                'user_management_login', [], UrlGeneratorInterface::ABSOLUTE_PATH
            );
            $event->setController(function() use ($url) {
                return new RedirectResponse($url);
            });
        }
    }

    private function validateUnauthenticatedController($controller, $event)
    {
        if (! $controller[0] instanceof UnauthenticatedController) {
            return;
        }

        if ($this->userSessionManager->isUserSessionAvailable()) {
            $url = $this->container->get('router')->generate(
                'user_management_home', [], UrlGeneratorInterface::ABSOLUTE_PATH
            );
            $event->setController(function() use ($url) {
                return new RedirectResponse($url);
            });
        }
    }
}
