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
        'Illuminate\Auth\Events\Login'      => [
            'App\Listeners\User\Auth\LogSuccessfulLogin',
        ],
        'Illuminate\Auth\Events\PasswordReset' => [
            'App\Listeners\User\Auth\ResetPassword\LogSuccessfulPasswordReset',
        ],
        'App\Events\Idea\IdeaHasReceived' => [
            'App\Listeners\Idea\IdeaHasBeenReceived'
        ],
        'App\Events\User\UserWasRegistered' => [
            // 'App\Listeners\User\SendActivationLink',
            'App\Listeners\User\SendNotificationPasswordEmail',
        ],
        'App\Events\Comite\ComiteWasRegistered' => [
            'App\Listeners\Comite\IdeaWasRegisteredInComite',
        ],
        'App\Events\Comite\AgendamientoWasRegistered' => [
            'App\Listeners\Comite\IdeaWasRegisteredInAgendamiento',
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
    }
}
