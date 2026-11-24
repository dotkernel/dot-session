<?php

declare(strict_types=1);

namespace DotTest\Session;

use Dot\Session\Options\SessionOptions;
use Dot\Session\SessionMiddleware;
use Laminas\Session\SessionManager;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\Stub;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddlewareTest extends TestCase
{
    private SessionMiddleware $sessionMiddleware;

    private SessionManager|Stub $sessionManager;
    private SessionOptions|Stub $sessionOptions;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->sessionManager = $this->createStub(SessionManager::class);
        $this->sessionOptions = $this->createStub(SessionOptions::class);

        $this->sessionMiddleware = new SessionMiddleware($this->sessionManager, $this->sessionOptions);
    }

    /**
     * @throws Exception
     */
    public function testProcess(): void
    {
        $requestInterface = $this->createStub(ServerRequestInterface::class);
        $handlerInterface = $this->createStub(RequestHandlerInterface::class);
        $process          = $this->sessionMiddleware->process($requestInterface, $handlerInterface);
        $this->assertContainsOnlyInstancesOf(ResponseInterface::class, [$process]);
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

        $requestInterface = $this->createStub(ServerRequestInterface::class);
        $handlerInterface = $this->createStub(RequestHandlerInterface::class);
        $process          = $this->sessionMiddleware->process($requestInterface, $handlerInterface);
        $this->assertContainsOnlyInstancesOf(ResponseInterface::class, [$process]);
    }
}
