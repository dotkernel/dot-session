<?php

declare(strict_types=1);

namespace Dot\Session;

use Dot\Session\Factory\ContainerAbstractServiceFactory;
use Dot\Session\Factory\SessionMiddlewareFactory;
use Dot\Session\Factory\SessionOptionsFactory;
use Dot\Session\Options\SessionOptions;
use Laminas\Session\Config\ConfigInterface;
use Laminas\Session\ManagerInterface;
use Laminas\Session\Service\SessionConfigFactory;
use Laminas\Session\Service\SessionManagerFactory;
use Laminas\Session\Service\StorageFactory;
use Laminas\Session\SessionManager;
use Laminas\Session\Storage\SessionArrayStorage;
use Laminas\Session\Storage\StorageInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies'       => $this->getDependencyConfig(),
            'session_manager'    => [
                'validators' => [],
                'options'    => [],
            ],
            'session_storage'    => [
                'type' => SessionArrayStorage::class,
            ],
            'session_containers' => [],
        ];
    }

    public function getDependencyConfig(): array
    {
        return [
            'aliases'            => [
                SessionManager::class => ManagerInterface::class,
            ],
            'factories'          => [
                ConfigInterface::class   => SessionConfigFactory::class,
                ManagerInterface::class  => SessionManagerFactory::class,
                StorageInterface::class  => StorageFactory::class,
                SessionOptions::class    => SessionOptionsFactory::class,
                SessionMiddleware::class => SessionMiddlewareFactory::class,
            ],
            'abstract_factories' => [
                ContainerAbstractServiceFactory::class,
            ],
        ];
    }
}
