<?php

namespace xguard\Http\Controllers\Api\Profile;

use xguard\Events\User\UpdatedProfileDetails;
use xguard\Http\Controllers\Api\ApiController;
use xguard\Http\Requests\User\UpdateProfileDetailsRequest;
use xguard\Http\Requests\User\UpdateProfileLoginDetailsRequest;
use xguard\Repositories\User\UserRepository;
use xguard\Transformers\UserTransformer;

/**
 * Class DetailsController
 * @package xguard\Http\Controllers\Api\Profile
 */
class AuthDetailsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Updates user profile details.
     * @param UpdateProfileLoginDetailsRequest $request
     * @param UserRepository $users
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileLoginDetailsRequest $request, UserRepository $users)
    {
        $user = $request->user();

        $data = $request->only(['email', 'username', 'password']);

        $user = $users->update($user->id, $data);

        return $this->respondWithItem($user, new UserTransformer);
    }
}
