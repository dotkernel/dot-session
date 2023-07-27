# dot-session

![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/dot-session)
![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/dot-session/5.4.0)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/dot-session)](https://github.com/dotkernel/dot-session/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/dot-session)](https://github.com/dotkernel/dot-session/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/dot-session)](https://github.com/dotkernel/dot-session/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/dot-session)](https://github.com/dotkernel/dot-session/blob/5.0/LICENSE.md)

[![SymfonyInsight](https://insight.symfony.com/projects/f6038340-d76b-4da8-9016-0472d4899f0a/big.svg)](https://insight.symfony.com/projects/f6038340-d76b-4da8-9016-0472d4899f0a)


DotKernel session component extending and customizing [laminas-session](https://github.com/laminas/laminas-session)

## Installation

Run the following command in your project folder
```bash
$ composer require dotkernel/dot-session
```
## Configuration

Add this:

    $app->pipe(Dot\Session\SessionMiddleware::class)  to config/pipeline.php

    \Dot\Session\ConfigProvider::class to config/config.php


## Usage

Basic usage to access and use the session object in your services

### Method #1 - Factory
Step 1
Create a factory that retrieves from container the SessionManger

```php
class ExampleFactory
{
    // code
    
    public function __invoke(ContainerInterface $container)
    {
        //return Session Service with  Session Manager from container
        return new ExampleService(
            $container->get(SessionManager::class)
        )
    }
}
```

Register the factory in any mode you register factories on your project.

Step 2 Access through your Service

```php

class ExampleService
{
    private SessionManager $session;
    
    public function __construct(SessionManager $session) 
    {
        $this->session = $session;
    }
    
     //you methods
}
```

### Method 2 - Injection
If you use annotated injection you can inject the Session Manager in your services.

```php
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
    
     //you methods
}
```
