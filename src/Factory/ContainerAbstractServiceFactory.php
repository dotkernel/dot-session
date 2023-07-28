<?php

declare(strict_types=1);

namespace Dot\Session\Factory;

use Laminas\Session\Container;
use Psr\Container\ContainerInterface;

use function count;
use function explode;

class ContainerAbstractServiceFactory extends \Laminas\Session\Service\ContainerAbstractServiceFactory
{
    public const PREFIX = 'dot-session';

    /**
     * @param string $requestedName
     */
    public function canCreate(ContainerInterface $container, $requestedName): bool
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

    /**
     * @param string $requestedName
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null): Container
    {
        $parts = explode('.', $requestedName);
        return parent::__invoke($container, $parts[1], $options);
    }
}
