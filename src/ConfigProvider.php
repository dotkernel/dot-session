<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-session
 * @author: n3vrax
 * Date: 9/5/2016
 * Time: 8:24 PM
 */

namespace DotKernel\DotSession;

use DotKernel\DotSession\Factory\SessionOptionsFactory;
use DotKernel\DotSession\Factory\SessionMiddlewareFactory;
use DotKernel\DotSession\Options\SessionOptions;
use Zend\Session\Storage\SessionArrayStorage;
use Zend\Stdlib\ArrayUtils;

/**
 * Class ConfigProvider
 * @package DotKernel\DotSession
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
            ],

            'session_config' => [
                'name' => 'DOT_SESSID',
                'remember_me_seconds' => 180,
                'use_cookies' => true,
                'cookie_httponly' => true,
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