<?php

namespace xguard\Http\Controllers\Web;

use Cache;
use xguard\Http\Controllers\Controller;
use xguard\Http\Requests\Role\CreateRoleRequest;
use xguard\Http\Requests\Role\UpdateRoleRequest;
use xguard\Repositories\Role\RoleRepository;
use xguard\Repositories\User\UserRepository;
use xguard\Role;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class RolesController
 * @package xguard\Http\Controllers
 */
class RolesController extends Controller
{
    /**
     * @var RoleRepository
     */
    private $roles;

    /**
     * RolesController constructor.
     * @param RoleRepository $roles
     */
    public function __construct(RoleRepository $roles)
    {
        $this->middleware('auth');
        $this->middleware('permission:roles.manage');
        $this->roles = $roles;
    }

    /**
     * Display page with all available roles.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $roles = $this->roles->getAllWithUsersCount();

        return view('role.index', compact('roles'));
    }

    /**
     * Display form for creating new role.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $edit = false;

        return view('role.add-edit', compact('edit'));
    }

    /**
     * Store newly created role to database.
     *
     * @param CreateRoleRequest $request
     * @return mixed
     */
    public function store(CreateRoleRequest $request)
    {
        $this->roles->create($request->all());

        return redirect()->route('role.index')
            ->withSuccess(trans('app.role_created'));
    }

    /**
     * Display for for editing specified role.
     *
     * @param Role $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Role $role)
    {
        $edit = true;

        return view('role.add-edit', compact('edit', 'role'));
    }

    /**
     * Update specified role with provided data.
     *
     * @param Role $role
     * @param UpdateRoleRequest $request
     * @return mixed
     */
    public function update(Role $role, UpdateRoleRequest $request)
    {
        $this->roles->update($role->id, $request->all());

        return redirect()->route('role.index')
            ->withSuccess(trans('app.role_updated'));
    }

    /**
     * Remove specified role from system.
     *
     * @param Role $role
     * @param UserRepository $userRepository
     * @return mixed
     */
    public function delete(Role $role, UserRepository $userRepository)
    {
        if (! $role->removable) {
            throw new NotFoundHttpException;
        }

        $userRole = $this->roles->findByName('User');

        $userRepository->switchRolesForUsers($role->id, $userRole->id);

        $this->roles->delete($role->id);

        Cache::flush();

        return redirect()->route('role.index')
            ->withSuccess(trans('app.role_deleted'));
    }
}