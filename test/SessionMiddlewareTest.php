<?php

declare(strict_types=1);

namespace DotTest\Session;

use Dot\Session\Options\SessionOptions;
use Dot\Session\SessionMiddleware;
use Laminas\Session\SessionManager;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddlewareTest extends TestCase
{
    private SessionMiddleware $sessionMiddleware;

    private SessionManager|MockObject $sessionManager;
    private SessionOptions|MockObject $sessionOptions;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->sessionManager = $this->createMock(SessionManager::class);
        $this->sessionOptions = $this->createMock(SessionOptions::class);

        $this->sessionMiddleware = new SessionMiddleware($this->sessionManager, $this->sessionOptions);
    }

    /**
     * @throws Exception
     */
    public function testProcess(): void
    {
        $requestInterface = $this->createMock(ServerRequestInterface::class);
        $handlerInterface = $this->createMock(RequestHandlerInterface::class);
        $process          = $this->sessionMiddleware->process($requestInterface, $handlerInterface);
        $this->assertInstanceOf(ResponseInterface::class, $process);
    }

    /**
     * @throws Exception
     */
    public function testProcessWithLastActivity(): void
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
