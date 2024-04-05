# Method #2 - Injection

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
