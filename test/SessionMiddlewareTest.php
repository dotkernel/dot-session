<?php

declare(strict_types=1);

namespace DotTest\Session;

use Dot\Session\Options\SessionOptions;
use Dot\Session\SessionMiddleware;
use Laminas\Session\SessionManager;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddlewareTest extends TestCase
{
    private SessionMiddleware $sessionMiddleware;

    private SessionManager $sessionManager;
    private SessionOptions $sessionOptions;

    protected function setUp(): void
    {
        $this->sessionManager = $this->createMock(SessionManager::class);
        $this->sessionOptions = $this->createMock(SessionOptions::class);

        $this->sessionMiddleware = new SessionMiddleware($this->sessionManager, $this->sessionOptions);
    }

    public function testProcess()
    {
        $requestInterface = $this->createMock(ServerRequestInterface::class);
        $handlerInterface = $this->createMock(RequestHandlerInterface::class);
        $process          = $this->sessionMiddleware->process($requestInterface, $handlerInterface);
        $this->assertInstanceOf(ResponseInterface::class, $process);
    }

    public function testProcessWithLastActivity()
    {
        $this->sessionManager->method('getStorage')
            ->willReturn(['LAST_ACTIVITY' => 1689849724]);

        $this->sessionOptions->method('getRememberMeInactive')
            ->willReturn(600);

        $requestInterface = $this->createMock(ServerRequestInterface::class);
        $handlerInterface = $this->createMock(RequestHandlerInterface::class);
        $process          = $this->sessionMiddleware->process($requestInterface, $handlerInterface);
        $this->assertInstanceOf(ResponseInterface::class, $process);
    }
}
