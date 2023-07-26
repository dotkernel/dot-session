<?php

declare(strict_types=1);

namespace DotTest\Session;

use Dot\Session\ConfigProvider;
use Dot\Session\Options\SessionOptions;
use Dot\Session\SessionMiddleware;
use Laminas\Session\Config\ConfigInterface;
use Laminas\Session\ManagerInterface;
use Laminas\Session\SessionManager;
use Laminas\Session\Storage\StorageInterface;
use PHPUnit\Framework\TestCase;

class ConfigProviderTest extends TestCase
{
    protected array $config;

    protected function setUp(): void
    {
        $this->config = (new ConfigProvider())();
    }

    public function testHasDependencies(): void
    {
        $this->assertArrayHasKey('dependencies', $this->config);
    }

    public function testDependenciesHasFactories(): void
    {
        $this->assertArrayHasKey('factories', $this->config['dependencies']);
        $this->assertArrayHasKey(ConfigInterface::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(ManagerInterface::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(StorageInterface::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(SessionOptions::class, $this->config['dependencies']['factories']);
        $this->assertArrayHasKey(SessionMiddleware::class, $this->config['dependencies']['factories']);
    }

    public function testDependenciesHasAliases()
    {
        $this->assertArrayHasKey('aliases', $this->config['dependencies']);
        $this->assertArrayHasKey(SessionManager::class, $this->config['dependencies']['aliases']);
    }

    public function testDependenciesHasAbstractFactories()
    {
        $this->assertArrayHasKey('abstract_factories', $this->config['dependencies']);
    }
}
