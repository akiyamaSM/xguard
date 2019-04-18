<?php

namespace xguard\Providers;

use xguard\Events\User\Banned;
use xguard\Events\User\LoggedIn;
use xguard\Events\User\Registered;
use xguard\Listeners\Users\InvalidateSessionsAndTokens;
use xguard\Listeners\Login\UpdateLastLoginTimestamp;
use xguard\Listeners\PermissionEventsSubscriber;
use xguard\Listeners\Registration\SendConfirmationEmail;
use xguard\Listeners\Registration\SendSignUpNotification;
use xguard\Listeners\RoleEventsSubscriber;
use xguard\Listeners\UserEventsSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendConfirmationEmail::class,
            SendSignUpNotification::class,
        ],
        LoggedIn::class => [
            UpdateLastLoginTimestamp::class
        ],
        Banned::class => [
            InvalidateSessionsAndTokens::class
        ]
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        UserEventsSubscriber::class,
        RoleEventsSubscriber::class,
        PermissionEventsSubscriber::class
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
