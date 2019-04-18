<?php

namespace xguard\Http\Controllers\Api;

use xguard\Http\Requests\Activity\GetActivitiesRequest;
use xguard\Repositories\Activity\ActivityRepository;
use xguard\Transformers\ActivityTransformer;

/**
 * Class ActivityController
 * @package xguard\Http\Controllers\Api
 */
class ActivityController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:users.activity');
    }

    /**
     * Paginate user activities.
     * @param GetActivitiesRequest $request
     * @param ActivityRepository $activities
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GetActivitiesRequest $request, ActivityRepository $activities)
    {
        $result = $activities->paginateActivities(
            $request->per_page ?: 20,
            $request->search
        );

        return $this->respondWithPagination(
            $result,
            new ActivityTransformer
        );
    }
}
