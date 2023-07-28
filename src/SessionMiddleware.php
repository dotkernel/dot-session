<?php

declare(strict_types=1);

namespace Dot\Session;

use Dot\Session\Options\SessionOptions;
use Laminas\Session\Container;
use Laminas\Session\SessionManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function time;

class SessionMiddleware implements MiddlewareInterface
{
    protected SessionManager $defaultSessionManager;

    protected SessionOptions $options;

    public function __construct(
        SessionManager $sessionManager,
        SessionOptions $options
    ) {
        $this->defaultSessionManager = $sessionManager;
        $this->options               = $options;
        Container::setDefaultManager($sessionManager);
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $now = time();
        if (
            isset($this->defaultSessionManager->getStorage()['LAST_ACTIVITY'])
            &&
            ($now - $this->defaultSessionManager->getStorage()['LAST_ACTIVITY'])
            > $this->options->getRememberMeInactive()
        ) {
            $this->defaultSessionManager->destroy(['send_expire_cookie' => true, 'clear_storage' => true]);
            $this->defaultSessionManager->start();
        }
        return $handler->handle($request);
    }
}
