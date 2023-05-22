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
        'App\Events\User\UserWasRegistered' => [
            'App\Listeners\User\SendWelcomeEmail',
        ],
        'App\Events\User\UserHasNewPasswordGenerated' => [
            'App\Listeners\User\SendEmailNewPasswordGenerated',
        ],
        'App\Events\User\CompletedTalentInformation' => [
            'App\Listeners\User\SendEmailCompletationInformationTalentNotification',
        ],
        'Illuminate\Auth\Events\Login'      => [
            'App\Listeners\User\Auth\LogSuccessfulLogin',
        ],
        'Illuminate\Auth\Events\PasswordReset' => [
            'App\Listeners\User\Auth\ResetPassword\LogSuccessfulPasswordReset',
        ],
        'App\Events\Idea\IdeaHasReceived' => [
            'App\Listeners\Idea\IdeaHasBeenReceived'
        ],
        'App\Events\Comite\ComiteWasRegistered' => [
            'App\Listeners\Comite\IdeaWasRegisteredInComite',
        ],
        'App\Events\Comite\AgendamientoWasRegistered' => [
            'App\Listeners\Comite\IdeaWasRegisteredInAgendamiento',
        ],
        'App\Events\Proyecto\ProyectoWasntApproved' => [
            'App\Listeners\Proyecto\ProyectoWasntApprovedInPhase',
        ],
        'App\Events\Proyecto\ProyectoWasApproved' => [
            'App\Listeners\Proyecto\ProyectoWasApprovedInPhase',
        ],
        'App\Events\Proyecto\ProyectoApproveWasRequested' => [
            'App\Listeners\Proyecto\ProyectoApproveWasRequestedInPhase',
        ],
        'App\Events\Proyecto\ProyectoSuspenderWasRequested' => [
            'App\Listeners\Proyecto\ProyectoSuspenderWasRequestedExperto',
        ],
        'App\Events\Comite\GestoresWereRegistered' => [
            'App\Listeners\Comite\GestoresWereRegisteredInAgendamiento',
        ],
        'App\Events\Idea\IdeasWasAccepted' => [
            'App\Listeners\Idea\IdeasWasAcceptedToComite',
        ],
        'App\Events\Idea\IdeasWasRejected' => [
            'App\Listeners\Idea\IdeasWasRejectedToComite',
        ],
        'App\Events\Support\MessageWasSent' => [
            'App\Listeners\Support\AutoReplyMessage',
        ],
        'App\Events\Proyecto\ProyectoApproveWasRequested' => [
            'App\Listeners\Proyecto\ProyectoApproveWasRequestedInPhase',
        ]
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
