<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-session
 * @author: n3vrax
 * Date: 9/5/2016
 * Time: 8:24 PM
 */

declare(strict_types = 1);

namespace Dot\Session;

use Dot\Session\Factory\ContainerAbstractServiceFactory;
use Dot\Session\Factory\SessionMiddlewareFactory;
use Dot\Session\Factory\SessionOptionsFactory;
use Dot\Session\Options\SessionOptions;
use Zend\Session\Config\ConfigInterface;
use Zend\Session\ManagerInterface;
use Zend\Session\Service\SessionConfigFactory;
use Zend\Session\Service\SessionManagerFactory;
use Zend\Session\Service\StorageFactory;
use Zend\Session\SessionManager;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Session\Storage\StorageInterface;

/**
 * Class ConfigProvider
 * @package Dot\Session
 */
class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),

            'dot_session' => [
                'remember_me_inactive' => 1800,
            ],

            'session_config' => [
                'name' => 'DOT_SESSID',
                'use_cookies' => true,
                'cookie_secure' => false,
                'cookie_httponly' => true,
                'remember_me_seconds' => 1800,
                'cookie_lifetime' => 1800,
                'gc_maxlifetime' => 1800,
            ],

            'session_manager' => [
                'validators' => [],
                'options' => [],
            ],

            'session_storage' => [
                'type' => SessionArrayStorage::class,
            ],

            'session_containers' => [],
        ];
    }

    /**
     * Merge our config with Zend Session dependencies
     * @return array
     */
    public function getDependencyConfig(): array
    {
        return [
            'aliases' => [
                SessionManager::class => ManagerInterface::class,
            ],
            'factories' => [
                ConfigInterface::class => SessionConfigFactory::class,
                ManagerInterface::class => SessionManagerFactory::class,
                StorageInterface::class => StorageFactory::class,

                SessionOptions::class => SessionOptionsFactory::class,
                SessionMiddleware::class => SessionMiddlewareFactory::class,
            ],
            'abstract_factories' => [
                ContainerAbstractServiceFactory::class,
            ]
        ];
    }
}
