<?php

declare(strict_types=1);

namespace DotTest\Session\Factory;

use Dot\Session\Factory\SessionOptionsFactory;
use Dot\Session\Options\SessionOptions;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class SessionOptionsFactoryTest extends TestCase
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
    public function testWillNotInstantiateWithoutConfig(): void
    {
        $this->container->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(false);

        $this->expectExceptionMessage('Unable to find config');
        $this->expectException(Exception::class);
        (new SessionOptionsFactory())($this->container);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillNotInstantiateWithoutDotLog(): void
    {
        $this->container->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $this->container->method('get')->willReturnMap([]);

        $this->expectExceptionMessage('Unable to find dot_session config');
        $this->expectException(Exception::class);
        (new SessionOptionsFactory())($this->container);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function testWillInstantiate(): void
    {
        $this->container->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $this->container->method('get')->willReturn([
            'dot_session' => [],
        ]);

        $factory = (new SessionOptionsFactory())($this->container);

        $this->assertInstanceOf(SessionOptions::class, $factory);
    }
}
