<?php


namespace Dot\Session\Factory;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Dot\Session\AutoLoginMiddleware;
use Dot\Session\Exception\RuntimeException;
use Dot\Session\Options\SessionOptions;
use Frontend\User\Authentication\PersistentAuthenticationAdapter;
use Frontend\User\Service\UserTokenService;
use Laminas\Authentication\AuthenticationService;
use Laminas\Session\SessionManager;
use Psr\Container\ContainerInterface;

class AutoLoginMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return AutoLoginMiddleware
     */
    public function __invoke(ContainerInterface $container)
    {
        return new AutoLoginMiddleware(
            $container->get(SessionManager::class),
            $container->get(SessionOptions::class),
            $container->get(AuthenticationService::class),
            $container->get(PersistentAuthenticationAdapter::class),
            $container->get(UserTokenService::class),
        );
    }
}