<?php

namespace Base\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Get module subscribers
        $subscribers = [];
        $modulesService = $this->app['modules'];
        $modules = $modulesService->getModules();
        foreach ($modules as $module) {
            foreach ($module->get('subscribers', []) as $subscriber) {
                $subscriber = $module->classFullyNamespaced($subscriber, 'listeners');
                Event::subscribe($subscriber);
            }
        }
    }
}
