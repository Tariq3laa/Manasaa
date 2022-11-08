<?php

namespace Modules\Admin\User\Http\Requests\Auth;

use Modules\Common\Http\Requests\ResponseShape;

class ResetPasswordRequest extends ResponseShape
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'forget_password_code'                  => 'required|exists:admins,forget_password_code',
            'password'                              => 'required|confirmed|min:6',
        ];
    }
}
