<?php

namespace Modules\Admin\User\Http\Requests\Auth;

use Modules\Common\Http\Requests\ResponseShape;

class LoginRequest extends ResponseShape
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'         => 'nullable|required_without:code|email:rfc,dns|exists:admins,email',
            'code'          => 'nullable|required_without:email|exists:admins,code',
            'password'      => 'required|min:6'
        ];
    }
}
