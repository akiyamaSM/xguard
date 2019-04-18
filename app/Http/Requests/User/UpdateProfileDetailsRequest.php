<?php

namespace xguard\Http\Requests\User;

use xguard\Http\Requests\Request;
use xguard\User;

class UpdateProfileDetailsRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'birthday' => 'nullable|date',
        ];
    }
}
