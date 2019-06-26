# laravel-faultline

```
composer require fusic/laravel-faultline
```

## Create config/faultline.php

```
<?php

$notifier = [
    'project' => env('FAULTLINE_PROJECT'),
    'apiKey' => env('FAULTLINE_API_KEY'),
    'endpoint' => env('FAULTLINE_ENDPINT'),
    'timeout' => env('FAULTLINE_TIMEOUT', '30.0'),
    'notifications' => [],

];

// Slack
if (env('FAULTLINE_SLACK_ENABLE', false)) {
    $notifier['notifications'][] = [
        'type' => 'slack',
        'endpoint' => env('FAULTLINE_SLACK_WEBHOOK_URL'),
        'channel' => env('FAULTLINE_SLACK_CHANNEL'),
        'username' => env('FAULTLINE_SLACK_USERNAME', 'faultline-notify'),
        'notifyInterval' => env('FAULTLINE_SLACK_INTERVAL', 5),
        'threshold' => env('FAULTLINE_SLACK_THRESHOLD', 10),
        'timezone' => env('FAULTLINE_SLACK_TIMEZONE', 'Asia/Tokyo'),
    ];
}

// GitHub
if (env('FAULTLINE_GITHUB_ENABLE', false)) {
    $notifier['notifications'][] = [
        'type' => 'github',
        'userToken' => env('FAULTLINE_GITHUB_TOKEN'),
        'owner' => env('FAULTLINE_GITHUB_OWNER'),
        'repo' => env('FAULTLINE_GITHUB_REPO'),
        'labels' => [
            'faultline', 'bug',
        ],
        'if_exist' => env('FAULTLINE_GITHUB_IF_EXIST', 'reopen-and-comment'),
        'notifyInterval' => env('FAULTLINE_GITHUB_INTERVAL', 1),
        'threshold' => env('FAULTLINE_GITHUB_THRESHOLD', 1),
        'timezone' => env('FAULTLINE_GITHUB_TIMEZONE', 'Asia/Tokyo'),
    ];
}

return [
    'config' => [
        'force' => false,
        'deny' => [
            '\Illuminate\Validation\ValidationException'
        ]
    ],
    'notifier' => $notifier,
];
```

## Add faultline environment to .env

```
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


```
    use LaravelFaultline\Exceptions\Handler\LaravelFaultline;

    public function report(Exception $exception)
    {
        LaravelFaultline::notify($exception);
        
        parent::report($exception);
    }
```
