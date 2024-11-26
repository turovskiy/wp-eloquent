<?php

namespace Turovskiy\WpEloquent\Events;

use Turovskiy\WpEloquent\Contracts\Queue\Factory as QueueFactoryContract;
use Turovskiy\WpEloquent\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('events', function ($app) {
            return (new Dispatcher($app))->setQueueResolver(function () use ($app) {
                return $app->make(QueueFactoryContract::class);
            });
        });
    }
}
