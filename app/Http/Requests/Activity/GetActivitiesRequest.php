<?php

namespace xguard\Http\Requests\Activity;

use xguard\Http\Requests\Request;
use xguard\User;

class GetActivitiesRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'per_page' => 'integer|max:100'
        ];
    }

    public function messages()
    {
        return [
            'per_page.max' => 'Maximum number of records per page is 100.'
        ];
    }
}
