# laravel-faultline

```sh
composer require fusic/laravel-faultline
```

## Create config/faultline.php

### Run

```sh
php artisan vendor:publish
```

## Add faultline environment to .env

```sh
# for faultline
FAULTLINE_PROJECT=xxxx
FAULTLINE_API_KEY=xxxx
FAULTLINE_ENDPINT=xxxx
FAULTLINE_TIMEOUT=xxxx
FAULTLINE_SLACK_ENABLE=true
FAULTLINE_SLACK_WEBHOOK_URL=xxxx
FAULTLINE_SLACK_USERNAME=xxxx
FAULTLINE_SLACK_CHANNEL=xxxx
# FAULTLINE_SLACK_INTERVAL=
# FAULTLINE_SLACK_THRESHOLD=
# FAULTLINE_SLACK_TIMEZONE=
# FAULTLINE_GITHUB_ENABLE=
# FAULTLINE_GITHUB_TOKEN=
# FAULTLINE_GITHUB_OWNER=
# FAULTLINE_GITHUB_REPO=
# FAULTLINE_GITHUB_IF_EXIST=
# FAULTLINE_GITHUB_INTERVAL=
# FAULTLINE_GITHUB_THRESHOLD=
# FAULTLINE_GITHUB_TIMEZONE=
```

## Add faultline report event to app/Exceptions/Handler.php

```php
    use LaravelFaultline\Exceptions\Handler\LaravelFaultline;

    public function report(Throwable $exception)
    {
        LaravelFaultline::notify($exception);
        
        parent::report($exception);
    }
```
