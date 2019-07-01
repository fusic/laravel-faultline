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
        'allowed_env' => [
            'production',
        ],
        'deny_exception' => [
            '\Illuminate\Validation\ValidationException',
        ],
    ],
    'notifier' => $notifier,
];
