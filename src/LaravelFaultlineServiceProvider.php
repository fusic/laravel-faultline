<?php
namespace LaravelFaultline;

use Illuminate\Support\ServiceProvider;

class LaravelFaultlineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/faultline.php' => app()->basePath('config/faultline.php'),
        ]);
    }
    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }
}
