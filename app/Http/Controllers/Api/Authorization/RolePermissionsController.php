<?php

namespace xguard\Http\Controllers\Api\Authorization;

use Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use xguard\Events\Role\PermissionsUpdated;
use xguard\Http\Controllers\Api\ApiController;
use xguard\Http\Requests\Role\CreateRoleRequest;
use xguard\Http\Requests\Role\RemoveRoleRequest;
use xguard\Http\Requests\Role\UpdateRolePermissionsRequest;
use xguard\Http\Requests\Role\UpdateRoleRequest;
use xguard\Repositories\Role\RoleRepository;
use xguard\Repositories\User\UserRepository;
use xguard\Role;
use xguard\Transformers\PermissionTransformer;
use xguard\Transformers\RoleTransformer;

/**
 * Class RolePermissionsController
 * @package xguard\Http\Controllers\Api
 */
class RolePermissionsController extends ApiController
{
    /**
     * @var RoleRepository
     */
    private $roles;

    public function __construct(RoleRepository $roles)
    {
        $this->roles = $roles;
        $this->middleware('auth');
        $this->middleware('permission:permissions.manage');
    }

    public function show(Role $role)
    {
        return $this->respondWithCollection(
            $role->cachedPermissions(),
            new PermissionTransformer
        );
    }

    /**
     * Update specified role.
     * @param Role $role
     * @param UpdateRolePermissionsRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Role $role, UpdateRolePermissionsRequest $request)
    {
        $this->roles->updatePermissions(
            $role->id,
            $request->permissions
        );

        event(new PermissionsUpdated);

        return $this->respondWithCollection(
            $role->cachedPermissions(),
            new PermissionTransformer
        );
    }
}
