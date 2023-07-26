<?php

declare(strict_types=1);

namespace DotTest\Session\Factory;

use Dot\Session\Factory\SessionMiddlewareFactory;
use Dot\Session\Options\SessionOptions;
use Dot\Session\SessionMiddleware;
use Exception;
use Laminas\Session\ManagerInterface;
use Laminas\Session\SessionManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class SessionMiddlewareFactoryTest extends TestCase
{
    private ContainerInterface|MockObject $container;

    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillInstantiateWithDefaultManager(): void
    {
        $this->container->expects($this->once())->method('has')
            ->with(ManagerInterface::class)
            ->willReturn(false);

        $this->container->expects($this->once())->method('get')
            ->with(SessionOptions::class)
            ->willReturn(new SessionOptions());

        $factory = (new SessionMiddlewareFactory())($this->container);

        $this->assertInstanceOf(SessionMiddleware::class, $factory);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillInstantiateWithManagerInterface(): void
    {
        $managerInterface = $this->createMock(SessionManager::class);
        $this->container->expects($this->once())->method('has')
            ->with(ManagerInterface::class)
            ->willReturn(true);

        $this->container->method('get')
            ->willReturnMap([
                [ManagerInterface::class, $managerInterface],
                [SessionOptions::class, new SessionOptions()],
            ]);

        $factory = (new SessionMiddlewareFactory())($this->container);

        $this->assertInstanceOf(SessionMiddleware::class, $factory);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillReturnException(): void
    {
        $this->container->expects($this->once())->method('has')
            ->with(ManagerInterface::class)
            ->willReturn(false);

        $this->container->expects($this->once())->method('get')
            ->with(SessionOptions::class)
            ->willReturn(null);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Unable to find ' . SessionOptions::class);
        (new SessionMiddlewareFactory())($this->container);
    }
}
