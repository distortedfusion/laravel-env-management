# Available Commands

## env:set

Replace an existing or append a new environment variable to the applications `.env` file.

### Replacing Existing Environment Variables

The `env:set` command requires 2 arguments, the environment variables `KEY` and `value`:

```bash
php artisan env:set APP_NAME Laravel
```

By wrapping the `value` in quotes you can provide strings with spaces:

```bash
php artisan env:set APP_NAME "Distorted Fusion"
```

Strings containing double quotes should be escaped beforehand:

```bash
php artisan env:set JSON_CONFIG "{\"foo\": \"bar\"}"
```

### Appending Existing Environment Variables

As a security measure you must supply `--apply` when adding new environment variables:

```bash
php artisan env:set NEW_VARIABLE "This didn't exist in the .env" --append
```

This will append the variable to the end of the `.env` file.

### Setting Environment Variables In Production

As a security measure you must supply `--force` when adding setting environment variables in production:

```bash
php artisan env:set APP_NAME "Distorted Fusion - Production" --force
```
