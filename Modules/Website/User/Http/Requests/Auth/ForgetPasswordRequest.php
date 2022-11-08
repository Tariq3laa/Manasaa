<?php

namespace Modules\Website\User\Http\Requests\Auth;

use Modules\Common\Rules\PhoneNumberRule;
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
            'email'         => 'nullable|required_without:phone|email:rfc,dns|exists:clients,email',
            'code'          => 'nullable|required_without:email|exists:clients,code',
        ];
    }
}
