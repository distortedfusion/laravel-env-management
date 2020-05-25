# Laravel Environment Management

[![Latest Version](https://img.shields.io/github/tag/distortedfusion/laravel-env-management.svg?style=flat-square)](https://github.com/distortedfusion/laravel-env-management/tags)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/distortedfusion/laravel-env-management/blob/master/LICENSE)
[![Build Status](https://img.shields.io/travis/distortedfusion/laravel-env-management.svg?style=flat-square)](https://travis-ci.org/distortedfusion/laravel-env-management)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/distortedfusion/laravel-env-management.svg?style=flat-square)](https://scrutinizer-ci.com/g/distortedfusion/laravel-env-management/)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/distortedfusion/laravel-env-management.svg?style=flat-square)](https://scrutinizer-ci.com/g/distortedfusion/laravel-env-management/?branch=master)

A collection of artisan commands for managing environment variables during CI/CD.

## Installation

Install the package via composer: `composer require distortedfusion/laravel-env-management`

*This package implements Laravel's Package Discovery, no further changes are needed to your application configs. For more information [please refer to the Laravel documentation](https://laravel.com/docs/packages#package-discovery).*

### Config

In order to edit the default configuration you need to publish the package configuration to your application config directory:

```sh
php artisan vendor:publish --tag=df-env-config
```

The config file will be published in config/env-management.php.

### Disabling commands

After publishing the package config, open `config/env-management.php` and look for the `commands` array.
Simply remove or comment out the command you don't want to be loaded.

## Available commands

All commands are enabled by default, refer to [disabling commands](https://github.com/distortedfusion/laravel-env-management#disabling-commands) if you don't require all commands.

### Getting/Setting the App Version

Setting an application version isn't a default Laravel feature.

For this to work you first need to add `APP_VERSION=` to your `.env` file and `'version' => env('APP_VERSION'),` to your `config/app.php`.

To set a version, simply run:
```sh
php artisan app:version 1.0.0
```

Running the command without specifying a version returns the currently set version:
```sh
php artisan app:version
```

### Setting the App Key

Setting an existing application key during continuous deployment is useful when running various instances of the same application with a shared backend. Or different applications that share the same session store.

To set an existing app key, simply run:
```sh
php artisan key:set base64:SGVsbG8gV29ybGQh
```

## License
The MIT License (MIT). Please see [License File](https://github.com/distortedfusion/laravel-env-management/blob/master/LICENSE) for more information.
