<?php
/**
 * @copyright: DotKernel
 * @library: dot-session
 * @author: n3vrax
 * Date: 2/3/2017
 * Time: 12:12 AM
 */

declare(strict_types = 1);

namespace Dot\Session\Factory;

use Interop\Container\ContainerInterface;

/**
 * Class ContainerAbstractServiceFactory
 * @package Dot\Session\Factory
 */
class ContainerAbstractServiceFactory extends \Zend\Session\Service\ContainerAbstractServiceFactory
{
    const PREFIX = 'dot-session';

    public function canCreate(ContainerInterface $container, $requestedName)
    {
        $parts = explode('.', $requestedName);
        if (count($parts) !== 2) {
            return false;
        }

        if ($parts[0] !== static::PREFIX) {
            return false;
        }

        return parent::canCreate($container, $parts[1]);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $parts = explode('.', $requestedName);
        return parent::__invoke($container, $parts[1], $options);
    }
}
