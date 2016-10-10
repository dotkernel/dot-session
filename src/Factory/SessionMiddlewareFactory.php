<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-session
 * @author: n3vrax
 * Date: 9/5/2016
 * Time: 8:24 PM
 */

namespace Dot\Session\Factory;

use Dot\Session\Options\SessionOptions;
use Dot\Session\SessionMiddleware;
use Interop\Container\ContainerInterface;
use Zend\Session\Container;
use Zend\Session\ManagerInterface;

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

        $middleware = new SessionMiddleware($sessionManager, $options);
        return $middleware;
    }
}