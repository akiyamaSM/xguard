<?php

namespace xguard\Listeners\Users;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use xguard\Events\User\Banned;
use xguard\Events\User\LoggedIn;
use xguard\Repositories\Session\SessionRepository;
use xguard\Repositories\User\UserRepository;
use xguard\Services\Auth\Api\Token;

class InvalidateSessionsAndTokens
{
    /**
     * @var SessionRepository
     */
    private $sessions;

    public function __construct(SessionRepository $sessions)
    {
        $this->sessions = $sessions;
    }

    /**
     * Handle the event.
     *
     * @param Banned $event
     * @return void
     */
    public function handle(Banned $event)
    {
        $user = $event->getBannedUser();

        $this->sessions->invalidateAllSessionsForUser($user->id);

        Token::where('user_id', $user->id)->delete();
    }
}
