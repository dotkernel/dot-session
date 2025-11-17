# Method #2 - Injection

If you are using [dot-dependency-injection](https://github.com/dotkernel/dot-dependency-injection) in your project, you don't need to create a separate factory, follow the below steps.

## Step 1: Access through your Service

```php
class ExampleService
{
    #[\Dot\DependencyInjection\Attribute\Inject(
        \Laminas\Session\SessionManager::class,
    )]
    public function __construct(
        private \Laminas\Session\SessionManager $session,
    ) {
    }
}
```

## Step 2: Register your service

Open the ConfigProvider of the module where your repository resides.

Add a new entry under `factories`, where the key is your service's FQCN and the value is `\Dot\DependencyInjection\Factory\AttributedServiceFactory`.

See the below example for a better understanding of the file structure.

```php
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
                ExampleService::class => \Dot\DependencyInjection\Factory\AttributedServiceFactory::class,
            ],
        ];
    }
}
```
