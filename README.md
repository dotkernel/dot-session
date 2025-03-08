# dot-session

Dotkernel session component extending and customizing [laminas-session](https://github.com/laminas/laminas-session)

> dot-session is a wrapper on top of [laminas/laminas-session](https://github.com/laminas/laminas-session)

## Documentation

Documentation is available at: https://docs.dotkernel.org/dot-session/.

## Badges

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/dot-session)
![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/dot-session/5.7.0)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/dot-session)](https://github.com/dotkernel/dot-session/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/dot-session)](https://github.com/dotkernel/dot-session/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/dot-session)](https://github.com/dotkernel/dot-session/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/dot-session)](https://github.com/dotkernel/dot-session/blob/5.0/LICENSE.md)

[![Build Static](https://github.com/dotkernel/dot-session/actions/workflows/continuous-integration.yml/badge.svg?branch=5.0)](https://github.com/dotkernel/dot-session/actions/workflows/continuous-integration.yml)
[![codecov](https://codecov.io/gh/dotkernel/dot-session/graph/badge.svg?token=DCHKH0R4AA)](https://codecov.io/gh/dotkernel/dot-session)
[![PHPStan](https://github.com/dotkernel/dot-session/actions/workflows/static-analysis.yml/badge.svg?branch=5.0)](https://github.com/dotkernel/dot-session/actions/workflows/static-analysis.yml)

## Installation

Run the following command in your project folder

```bash
    composer require dotkernel/dot-session
```

## Configuration

Register `SessionMiddleware` in your application's pipeline by adding the following line to `config/pipeline.php`:

```php
    $app->pipe(Dot\Session\SessionMiddleware::class);
```

Register `dot-session`'s ConfigProvider in your application's configurations by adding the following line to `config/config.php`:

```php
    \Dot\Session\ConfigProvider::class,
```

## Usage

Basic usage to access and use the session object in your services:

### Method #1 - Factory

#### Step 1: Create a factory that retrieves the SessionManger from the container

```php
class ExampleFactory
{
    // code
    
    public function __invoke(ContainerInterface $container)
    {
        return new ExampleService(
            $container->get(SessionManager::class)
        )
    }
}
```

Register the factory in any mode you register factories on your project.

#### Step 2: Access through your Service

```php

class ExampleService
{
    private SessionManager $session;
    
    public function __construct(SessionManager $session) 
    {
        $this->session = $session;
    }
    
     //your methods
}
```

### Method #2 - Injection

If you use annotated injection you can inject the Session Manager in your services.

```php
use Dot\AnnotatedServices\Annotation\Inject;
use Laminas\Session\SessionManager;

class ExampleService
{
    private SessionManager $session;
    
     /**
     * @Inject({SessionManager::class})
     */
    public function __construct(SessionManager $session) 
    {
        $this->session = $session;
    }
    
     //your methods
}
```
