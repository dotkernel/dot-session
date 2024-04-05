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

Register the factory in any mode you register factories on your project.

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
