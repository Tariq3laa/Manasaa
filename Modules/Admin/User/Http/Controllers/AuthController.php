<?php

namespace Modules\Admin\User\Http\Controllers;

use Modules\Admin\User\Services\AuthService;
use Modules\Admin\User\Http\Requests\Auth\LoginRequest;
use Modules\Admin\User\Http\Requests\Auth\RegisterRequest;
use Modules\Admin\User\Http\Requests\Auth\ResetPasswordRequest;
use Modules\Admin\User\Http\Requests\Auth\ForgetPasswordRequest;

class AuthController
{
    private $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(LoginRequest $request)
    {
        return $this->service->login($request);
    }

    public function register(RegisterRequest $request)
    {
        return $this->service->register($request);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        return $this->service->forgetPassword($request);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->service->resetPassword($request);
    }

    public function profile()
    {
        return $this->service->profile();
    }

    public function generateUniqueCode()
    {
        return $this->service->generateUniqueCode();
    }
}
