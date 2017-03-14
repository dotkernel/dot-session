<?php
/**
 * @see https://github.com/dotkernel/dot-session/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-session/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Session;

use Dot\Session\Options\SessionOptions;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;

/**
 * Class SessionMiddleware
 * @package Dot\Session
 */
class SessionMiddleware implements MiddlewareInterface
{
    /** @var  SessionManager */
    protected $defaultSessionManager;

    /** @var  SessionOptions */
    protected $options;

    /**
     * SessionMiddleware constructor.
     * @param SessionManager $sessionManager
     * @param SessionOptions $options
     */
    public function __construct(SessionManager $sessionManager, SessionOptions $options)
    {
        $this->defaultSessionManager = $sessionManager;
        $this->options = $options;
        Container::setDefaultManager($sessionManager);
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate): ResponseInterface
    {
        $this->defaultSessionManager->start();

        /** @var SessionConfig $config */
        $config = $this->defaultSessionManager->getConfig();
        if (isset($_SESSION['LAST_ACTIVITY'])
            && time() - $_SESSION['LAST_ACTIVITY'] > $this->options->getRememberMeInactive()
        ) {
            $this->defaultSessionManager->destroy(['send_expire_cookie' => true, 'clear_storage' => true]);
            $this->defaultSessionManager->start();
        }
        $_SESSION['LAST_ACTIVITY'] = time();
        if ($config->getUseCookies()) {
            setcookie(
                $config->getName(),
                $this->defaultSessionManager->getId(),
                time() + $config->getCookieLifetime(),
                $config->getCookiePath(),
                $config->getCookieDomain(),
                (bool) $config->getCookieSecure(),
                (bool) $config->getCookieHttpOnly()
            );
        }

        return $delegate->process($request);
    }
}
