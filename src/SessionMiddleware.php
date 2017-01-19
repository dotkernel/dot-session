<?php
/**
 * @copyright: DotKernel
 * @library: dotkernel/dot-session
 * @author: n3vrax
 * Date: 9/5/2016
 * Time: 8:24 PM
 */

namespace Dot\Session;

use Dot\Session\Options\SessionOptions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;

/**
 * Class SessionMiddleware
 * @package Dot\Session
 */
class SessionMiddleware
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
     * @param ResponseInterface $response
     * @param callable|null $next
     * @return mixed
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        //start the session and insert a default container into the request object
        $this->defaultSessionManager->start();

        /** @var SessionConfig $config */
        $config = $this->defaultSessionManager->getConfig();
        if (isset($_SESSION['LAST_ACTIVITY'])
            && time() - $_SESSION['LAST_ACTIVITY'] > $this->options->getRememberMeInactive()) {
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
                $config->getCookieSecure(),
                $config->getCookieHttpOnly()
            );
        }

        $container = new Container($this->options->getSessionNamespace());

        $request = $request->withAttribute($this->options->getSessionNamespace(), $container);

        return $next($request, $response);
    }
}
