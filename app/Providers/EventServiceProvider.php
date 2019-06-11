<?php

namespace App\Providers;

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
        Registered::class                   => [
            SendEmailVerificationNotification::class,
        ],
        'Illuminate\Auth\Events\Registered' => [
            'App\Listeners\SendActivationLink',
        ],
        'Illuminate\Auth\Events\Login'      => [
            'App\Listeners\LogSuccessfulLogin',
        ],
        'App\Events\Idea\IdeaHasReceived' => [
            'App\Listeners\IdeaHasBeenReceived'
        ],
        'App\Events\User\UserWasRegistered' => [
            'App\Listeners\User\UserWelcome',
            'App\Listeners\User\SendNotificationPasswordEmail',
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

        //
    }
}
