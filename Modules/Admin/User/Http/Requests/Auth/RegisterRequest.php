<?php

namespace Modules\Admin\User\Http\Requests\Auth;

use Modules\Common\Http\Requests\ResponseShape;

class RegisterRequest extends ResponseShape
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          => 'required|min:2',
            'email'         => 'nullable|required_without:code|email:rfc,dns|unique:admins,email',
            'code'          => 'nullable|required_without:email|unique:admins,code',
            'password'      => 'required|confirmed|min:6'
        ];
    }
}
