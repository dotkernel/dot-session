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
use Zend\Session\Container;
use Zend\Session\ManagerInterface;

/**
 * Class SessionMiddleware
 * @package Dot\Session
 */
class SessionMiddleware
{
    /** @var  ManagerInterface */
    protected $defaultSessionManager;

    /** @var  SessionOptions */
    protected $options;

    /**
     * SessionMiddleware constructor.
     * @param ManagerInterface $sessionManager
     * @param SessionOptions $options
     */
    public function __construct(ManagerInterface $sessionManager, SessionOptions $options)
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
        $container = new Container($this->options->getSessionNamespace());

        $request = $request->withAttribute($this->options->getSessionNamespace(), $container);

        return $next($request, $response);
    }
}