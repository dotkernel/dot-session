<?php
/**
 * @see https://github.com/dotkernel/dot-session/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/dotkernel/dot-session/blob/master/LICENSE.md MIT License
 */

declare(strict_types = 1);

namespace Dot\Session;

use Dot\Session\Options\SessionOptions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Laminas\Session\Config\SessionConfig;
use Laminas\Session\Container;
use Laminas\Session\SessionManager;

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
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
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
        return $handler->handle($request);
    }
}
