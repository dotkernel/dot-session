# dot-session

DotKernel session component extending and customizing [laminas-session](https://github.com/laminas/laminas-session)

## Installation

Run the following command in your project folder
```bash
$ composer require dotkernel/dot-session
```

## Usage

Next, inject this service in you classes, wherever you need session.
```php
$app->pipe(SessionMiddleware::class);
```