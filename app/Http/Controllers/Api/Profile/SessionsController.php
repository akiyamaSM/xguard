<?php

namespace xguard\Http\Controllers\Api\Profile;

use xguard\Http\Controllers\Api\ApiController;
use xguard\Repositories\Session\SessionRepository;
use xguard\Transformers\SessionTransformer;

/**
 * Class DetailsController
 * @package xguard\Http\Controllers\Api\Profile
 */
class SessionsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('session.database');
    }

    /**
     * Handle user details request.
     * @param SessionRepository $sessions
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SessionRepository $sessions)
    {
        $sessions = $sessions->getUserSessions(auth()->id());

        return $this->respondWithCollection(
            $sessions,
            new SessionTransformer
        );
    }
}
