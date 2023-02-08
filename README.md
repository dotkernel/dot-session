![OSS Lifecycle](https://img.shields.io/osslifecycle/dotkernel/dot-session)
![PHP from Packagist (specify version)](https://img.shields.io/packagist/php-v/dotkernel/dot-session/4.4.0)

[![GitHub issues](https://img.shields.io/github/issues/dotkernel/dot-session)](https://github.com/dotkernel/dot-session/issues)
[![GitHub forks](https://img.shields.io/github/forks/dotkernel/dot-session)](https://github.com/dotkernel/dot-session/network)
[![GitHub stars](https://img.shields.io/github/stars/dotkernel/dot-session)](https://github.com/dotkernel/dot-session/stargazers)
[![GitHub license](https://img.shields.io/github/license/dotkernel/dot-session)](https://github.com/dotkernel/dot-session/blob/4.0/LICENSE.md)

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
