<?php

namespace xguard\Http\Controllers\Api\Profile;

use Authy;
use xguard\Events\User\TwoFactorDisabled;
use xguard\Events\User\TwoFactorEnabled;
use xguard\Http\Controllers\Api\ApiController;
use xguard\Http\Requests\User\EnableTwoFactorRequest;
use xguard\Transformers\UserTransformer;

/**
 * Class TwoFactorController
 * @package xguard\Http\Controllers\Api\Profile
 */
class TwoFactorController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Enable 2FA for specified user.
     * @param EnableTwoFactorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(EnableTwoFactorRequest $request)
    {
        $user = auth()->user();

        if (Authy::isEnabled($user)) {
            return $this->setStatusCode(422)
                ->respondWithError("2FA is already enabled for this user.");
        }

        $user->setAuthPhoneInformation(
            $request->country_code,
            $request->phone_number
        );

        Authy::register($user);

        $user->save();

        event(new TwoFactorEnabled);

        return $this->respondWithItem($user, new UserTransformer);
    }

    /**
     * Disable 2FA for currently authenticated user.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $user = auth()->user();

        if (! Authy::isEnabled($user)) {
            return $this->setStatusCode(422)
                ->respondWithError("2FA is not enabled for this user.");
        }

        Authy::delete($user);

        $user->save();

        event(new TwoFactorDisabled);

        return $this->respondWithItem($user, new UserTransformer);
    }
}
