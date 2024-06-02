<?php

namespace Devzkhalil\TrovitXmlFeed;

use Illuminate\Support\ServiceProvider;

class TrovitXmlFeedServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('TrovitXmlFeed', function () {
            return new TrovitXmlFeed;
        });

        $this->mergeConfigFrom(
            __DIR__ . '/config/trovit.php',
            'trovit'
        );
    }

    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/config/trovit.php' => config_path('trovit.php'),
            ],
            ['trovit']
        );
    }
}
