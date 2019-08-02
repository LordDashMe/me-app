<?php

namespace AppCommon\Application\EventSubscriber;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use UserManagement\Domain\Service\UserSessionManager;

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

        $this->onAuthHandler($controller, $event);        
    }

    private function onAuthHandler($controller, FilterControllerEvent $event)
    {
        if ($controller[0] instanceof \AppCommon\Application\Controller\Security\UnauthenticatedController) {
            if ($this->userSessionManager->isUserSessionAvailable()) {
                $this->authRedirection('expense_management', $event);
            }
        }

        if ($controller[0] instanceof \AppCommon\Application\Controller\Security\AuthenticatedController) {
            if (! $this->userSessionManager->isUserSessionAvailable()) {
                $this->authRedirection('user_management_login', $event);
            }
        }
    }

    private function authRedirection(string $resource, FilterControllerEvent $event)
    {
        $url = $this->container->get('router')->generate(
            $resource, [], UrlGeneratorInterface::ABSOLUTE_PATH
        );
        
        $event->setController(function() use ($url) {
            return new RedirectResponse($url);
        });    
    }
}
