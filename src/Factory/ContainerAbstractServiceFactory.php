<?php
/**
 * @see https://github.com/dotkernel/dot-session/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-session/blob/master/LICENSE.md MIT License
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
