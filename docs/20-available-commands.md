# Available Commands

All commands are enabled by default, refer to [Disabling Commands](https://distortedfusion.com/docs/distortedfusion/laravel-env-management/getting-started#disabling-commands) if you don't require all commands.

## env:set



## app:url

Set the application url

Setting a dynamic url during continuous deployment might be useful when, for example, you're running multiple installations per feature branch on dedicated sub-domains.

### Usage

To set an app url, simply run:

```sh
php artisan app:url http://staging.app.dev
```

## app:version

Get or set the application version

Setting an application version isn't a built in Laravel feature.

**Please note:** For this command you need to make changes to your application!

- Add `APP_VERSION=` to your `.env` file, this is used to permanently store the application version.
- Add the `version` config variable to your `config/app.php` like, `'version' => env('APP_VERSION'),`.

### Usage

To set a version, simply run:

```sh
php artisan app:version 1.0.0
```

Running the command without specifying a version returns the currently set version:

```sh
php artisan app:version
```

## key:set

Set the application key

Setting an existing application key during continuous deployment is useful when running various instances of the same application with a shared backend. Or different applications that share the same session store.

### Usage

To set an existing app key, simply run:

```sh
php artisan key:set base64:SGVsbG8gV29ybGQh
```
