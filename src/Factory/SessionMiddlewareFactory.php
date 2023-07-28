<?php

declare(strict_types=1);

namespace Dot\Session\Factory;

use Dot\Session\Options\SessionOptions;
use Dot\Session\SessionMiddleware;
use Exception;
use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class SessionMiddlewareFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function __invoke(ContainerInterface $container): SessionMiddleware
    {
        $sessionManager = $container->has(ManagerInterface::class)
            ? $container->get(ManagerInterface::class)
            : Container::getDefaultManager();

        $options = $container->get(SessionOptions::class);

        if (! $options instanceof SessionOptions) {
            throw new Exception('Unable to find ' . SessionOptions::class);
        }

        return new SessionMiddleware(
            $sessionManager,
            $options
        );
    }
}
