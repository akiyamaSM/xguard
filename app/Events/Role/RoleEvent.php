<?php

namespace xguard\Events\Role;

use xguard\Role;

abstract class RoleEvent
{
    /**
     * @var Role
     */
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
}