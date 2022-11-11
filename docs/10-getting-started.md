# Getting Started

A collection of artisan commands for managing environment variables during CI/CD.

## Installation

The package can be installed via composer:

```bash
composer require distortedfusion/laravel-env-management
```

*This package implements Laravel's Package Discovery, no further changes are needed to your application configurations. For more information [please refer to the Laravel documentation](https://laravel.com/docs/packages#package-discovery).*

## Version Compatibility

| Laravel | PHP            | Package |
| ------- | -------------- | ------- |
| 6.x     | ^7.2           | >= 1.0  |
| 7.x     | ^7.2           | >= 1.0  |
| 9.x     | ^8.0           | >= 2.0  |

## Configuration

In order to edit the default configuration you need to publish the package configuration to your application config directory:

```bash
php artisan vendor:publish --tag=df-env-config
```

The configuration file will be published to `config/env-management.php` in your application directory. Please refer to the [config file](https://github.com/distortedfusion/laravel-env-management/blob/master/config/env-management.php) for an overview of the available options.

## Disabling Commands

After publishing the configuration file, open `config/env-management.php` and look for the `commands` array.

Commands can be disabled by removing them or commenting them out.
