<?php

declare(strict_types=1);

namespace DotTest\Session\Factory;

use Dot\Session\Factory\ContainerAbstractServiceFactory;
use Exception;
use Laminas\Session\Container;
use Laminas\Session\ManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ContainerAbstractServiceFactoryTest extends TestCase
{
    private ContainerInterface|MockObject $container;

    private ContainerAbstractServiceFactory $factory;

    protected array $config = [
        'session_containers' => [
            'name' => 'test',
        ],
    ];

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->container = $this->createMock(ContainerInterface::class);
        $this->factory   = new ContainerAbstractServiceFactory();
    }

    public function testInstantiate(): void
    {
        $this->container->expects($this->once())
            ->method('has')
            ->with(ManagerInterface::class)
            ->willReturn(true);

        $this->container->expects($this->once())
            ->method('get')
            ->with(ManagerInterface::class)
            ->willReturnMap([ManagerInterface::class]);

        $factory = (new ContainerAbstractServiceFactory())($this->container, 'dot-session.test');
        $this->assertInstanceOf(Container::class, $factory);
    }

    public function testCanCreate(): void
    {
        $this->container->expects($this->once())
            ->method('has')
            ->with('config')
            ->willReturn(true);

        $this->container->expects($this->once())
            ->method('get')
            ->with('config')
            ->willReturn($this->config);

        $this->assertFalse($this->factory->canCreate($this->container, 'dot-session.not_in_config_name'));
        $this->assertTrue($this->factory->canCreate($this->container, 'dot-session.test'));
    }
}
