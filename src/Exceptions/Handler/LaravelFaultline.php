<?php
namespace LaravelFaultline\Exceptions\Handler;

use Faultline\Instance;
use Faultline\Notifier;
use Illuminate\Support\Facades\App;

class LaravelFaultline
{
    private const DEFAULT_CONFIG = [
        'force' => false,
        'deny' => [
            '\Illuminate\Validation\ValidationException'
        ]
    ];

    /**
     * notify
     *
     * @param $exception
     * @throws \Faultline\Exception
     */
    public static function notify($exception): void
    {
        if (!self::isSetup()) {
            return ;
        }

        $config = config('faultline.config', []);
        $config = array_merge(self::DEFAULT_CONFIG, $config);

        if ((App::isLocal() || App::runningUnitTests()) && $config['force'] === false) {
            return ;
        }

        if (self::checkDeny($config['deny'], $exception)) {
            return ;
        }

        // Create new Notifier instance.
        $notifier = new Notifier(config('faultline.notifier'));

        // Set global notifier instance.
        Instance::set($notifier);

        Instance::notify($exception);
    }

    /**
     * checkDeny
     *
     * @param $denyList
     * @param $exception
     * @return bool
     */
    private static function checkDeny($denyList, $exception): bool
    {
        foreach ($denyList as $deny)
        {
            if (is_a($exception,$deny)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    private static function isSetup(): bool
    {
        $checkList = [
            'FAULTLINE_PROJECT',
            'FAULTLINE_API_KEY',
            'FAULTLINE_ENDPINT'
        ];

        foreach ($checkList as $check)
        {
            if (empty(env($check))) {
                return false;
            }
        }

        return true;
    }
}
