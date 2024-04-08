# Method #1 - Factory

## Step 1: Create a factory that retrieves the SessionManger from the container

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

## Step 2: Access through your Service

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

## Step 3: Register the factory

Open the ConfigProvider of the module where your repository resides.

Add a new entry under `factories`, where the key is your service's FQCN and the value is your factory's FQCN.

See below example for a better understanding of the file structure.

```php
<?php

declare(strict_types=1);

namespace YourApp;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
                ExampleService::class => ExampleFactory::class,
            ],
        ];
    }
}
```
