<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-session
 * @author: n3vrax
 * Date: 9/5/2016
 * Time: 8:24 PM
 */

namespace DotKernel\DotSession\Factory;


use DotKernel\DotSession\Options\SessionOptions;
use Interop\Container\ContainerInterface;

/**
 * Class SessionOptionsFactory
 * @package DotKernel\DotSession\Factory
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