# Configuration
Register `SessionMiddleware` in your application's pipeline by adding the following line to `config/pipeline.php`:

    $app->pipe(Dot\Session\SessionMiddleware::class);

Register `dot-session`'s ConfigProvider in your application's configurations by adding the following line to `config/config.php`:

    \Dot\Session\ConfigProvider::class,
