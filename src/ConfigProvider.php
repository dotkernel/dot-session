<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-session
 * @author: n3vrax
 * Date: 9/5/2016
 * Time: 8:24 PM
 */

namespace Dot\Session;

use Dot\Session\Factory\SessionMiddlewareFactory;
use Dot\Session\Factory\SessionOptionsFactory;
use Dot\Session\Options\SessionOptions;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Stdlib\ArrayUtils;

/**
 * Class ConfigProvider
 * @package Dot\Session
 */
class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencyConfig(),

            'dot_session' => [
                'session_namespace' => 'dot_session',
                'remember_me_inactive' => 1800,
            ],

            'session_config' => [
                'name' => 'DOTSESSID',
                'use_cookies' => true,
                'cookie_httponly' => true,
                'remember_me_seconds' => 1800,
                'cookie_lifetime' => 1800,
                'gc_maxlifetime' => 1800,
            ],

            'session_manager' => [
                'validators' => [

                ],
                'options' => [

                ],
            ],

            'session_storage' => [
                'type' => SessionArrayStorage::class,
            ],

            'session_containers' => [

            ],
        ];
    }

    /**
     * Merge our config with Zend Session dependencies
     * @return array
     */
    public function getDependencyConfig()
    {
        $zendSessionConfigProvider = new \Zend\Session\ConfigProvider();
        $config = [
            'factories' => [

                SessionOptions::class => SessionOptionsFactory::class,

                SessionMiddleware::class => SessionMiddlewareFactory::class,
            ],
        ];

        return ArrayUtils::merge($config, $zendSessionConfigProvider->getDependencyConfig());
    }
}
