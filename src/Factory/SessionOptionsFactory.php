<?php
/**
 * @see https://github.com/dotkernel/dot-session/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-session/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Session\Factory;

use Dot\Session\Options\SessionOptions;
use Psr\Container\ContainerInterface;

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
