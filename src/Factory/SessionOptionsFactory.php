<?php

declare(strict_types=1);

namespace Dot\Session\Factory;

use Dot\Session\Options\SessionOptions;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function is_array;

class SessionOptionsFactory
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws Exception
     */
    public function __invoke(ContainerInterface $container): SessionOptions
    {
        if (! $container->has('config')) {
            throw new Exception('Unable to find config');
        }

        $config = $container->get('config');

        if (! isset($config['dot_session']) || ! is_array($config['dot_session'])) {
            throw new Exception('Unable to find dot_session config');
        }

        $config = $config['dot_session'];

        return new SessionOptions($config);
    }
}
