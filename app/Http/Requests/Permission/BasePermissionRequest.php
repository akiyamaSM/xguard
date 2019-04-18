<?php

namespace xguard\Http\Requests\Permission;

use xguard\Http\Requests\Request;

class BasePermissionRequest extends Request
{
    /**
     * Validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.unique' => trans('app.permission_already_exists')
        ];
    }
}