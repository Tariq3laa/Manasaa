<?php

namespace Modules\Admin\User\Services;

use Illuminate\Support\Facades\DB;
use Modules\Common\Jobs\SendEmail;
use Modules\Admin\User\Repositories\AuthRepository;
use Modules\Common\Http\Controllers\InitController;

class AuthService extends InitController
{
    private $repository;

    public function __construct(AuthRepository $repository)
    {
        parent::__construct();
        $this->repository = $repository;
    }

    public function login($request)
    {
        try {
            return $this->respondWithSuccess($this->repository->login($request));
        } catch (\Exception $e) {
            $code = getCode($e->getCode());
            $message = $e->getMessage();
            return jsonResponse($code, $message);
        }
    }

    public function register($request)
    {
        try {
            return $this->respondCreated([$this->repository->register($request)]);
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function forgetPassword($request)
    {
        try {
            $item = $this->repository->forgetPassword($request);
            $email_data = [
                'template_path'         => 'adminUser::emails.auth.forget_password',
                'subject'               => 'Admin Forget Password',
                'receiver_email'        => $item->email,
                'name'                  => $item->name,
                'code'                  => $item->forget_password_code,
                'home_link'             => env('FRONT_URL'),
                'link'                  => env('FRONT_URL') . '/admin/reset-password'
            ];
            SendEmail::dispatch($email_data);
            return $this->respondOk('Email Sent to your email');
        } catch (\Exception $e) {
            DB::rollBack();
            $code = getCode($e->getCode());
            $message = $e->getMessage();
            return jsonResponse($code, $message);
        }
    }

    public function resetPassword($request)
    {
        try {
            return $this->respondWithSuccess($this->repository->resetPassword($request));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respondError($e->getMessage());
        }
    }

    public function profile()
    {
        try {
            return $this->respondWithSuccess($this->repository->profile());
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }

    public function generateUniqueCode()
    {
        try {
            return $this->respondWithSuccess($this->repository->generateUniqueCode());
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }
    }
}