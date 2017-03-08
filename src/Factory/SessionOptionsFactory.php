<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-session
 * @author: n3vrax
 * Date: 9/5/2016
 * Time: 8:24 PM
 */

declare(strict_types = 1);

namespace Dot\Session\Factory;

use Dot\Session\Options\SessionOptions;
use Interop\Container\ContainerInterface;

/**
 * Class SessionOptionsFactory
 * @package Dot\Session\Factory
 */
class SessionOptionsFactory
{
    /**
     * @param ContainerInterface $container
     * @return SessionOptions
     */
    public function __invoke(ContainerInterface $container)
    {
        return new SessionOptions($container->get('config')['dot_session']);
    }
}
