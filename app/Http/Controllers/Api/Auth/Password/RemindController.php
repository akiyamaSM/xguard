<?php

namespace xguard\Http\Controllers\Api\Auth\Password;

use xguard\Events\User\RequestedPasswordResetEmail;
use xguard\Http\Controllers\Api\ApiController;
use xguard\Http\Requests\Auth\PasswordRemindRequest;
use xguard\Notifications\ResetPassword;
use xguard\Repositories\User\UserRepository;
use Password;

class RemindController extends ApiController
{
    /**
     * Create a new password controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param PasswordRemindRequest $request
     * @param UserRepository $users
     * @return \Illuminate\Http\Response
     */
    public function index(PasswordRemindRequest $request, UserRepository $users)
    {
        $user = $users->findByEmail($request->email);

        $token = Password::getRepository()->create($user);

        $user->notify(new ResetPassword($token));

        event(new RequestedPasswordResetEmail($user));

        return $this->respondWithSuccess();
    }
}
