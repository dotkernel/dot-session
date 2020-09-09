<?php
/**
 * @see https://github.com/dotkernel/dot-session/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-session/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Session\Factory;

use Doctrine\ORM\EntityManager;
use Dot\Session\Exception\RuntimeException;
use Dot\Session\Options\SessionOptions;
use Dot\Session\SessionMiddleware;
use Laminas\Authentication\AuthenticationService;
use Psr\Container\ContainerInterface;
use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;
use Laminas\Log\Logger;


/**
 * Class SessionMiddlewareFactory
 * @package Dot\Session\Factory
 */
class SessionMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return SessionMiddleware
     */
    public function __invoke(ContainerInterface $container)
    {
        $sessionManager = $container->has(ManagerInterface::class)
            ? $container->get(ManagerInterface::class)
            : Container::getDefaultManager();

        $options = $container->get(SessionOptions::class);
        return new SessionMiddleware(
            $sessionManager,
            $options
        );
    }
}
