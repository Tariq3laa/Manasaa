<?php

namespace Modules\Admin\User\Http\Requests\Auth;

use Modules\Common\Http\Requests\ResponseShape;

class ForgetPasswordRequest extends ResponseShape
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'         => 'nullable|required_without:phone|email:rfc,dns|exists:admins,email',
            'code'          => 'nullable|required_without:email|exists:admins,code',
        ];
    }
}
