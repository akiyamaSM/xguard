<?php

namespace xguard\Http\Requests\User;

use xguard\Http\Requests\BinaryFileUploadRequest;

class UploadAvatarRawRequest extends BinaryFileUploadRequest
{
    public function rules()
    {
        return [
            'file' => 'required|image'
        ];
    }

    public function messages()
    {
        return [
            "file.required" => 'The file is required.'
        ];
    }
}
