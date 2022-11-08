<?php

namespace Modules\Admin\User\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Admin\User\Entities\Admin;
use Modules\Admin\User\Transformers\AdminResource;

class AuthRepository
{
    public function login($request)
    {
        if($request->filled('email')) {
            $credentials = $request->only(['email', 'password']);
            $item = Admin::query()->firstWhere('email', $request->email);
        } else if($request->filled('code')) {
            $credentials = $request->only(['code', 'password']);
            $item = Admin::query()->firstWhere('code', $request->code);
        }
        if (!$item['access_token'] = auth('admin')->attempt($credentials, true)) throw new \Exception('The email or code or password you entered is invalid.', 401);
        return new AdminResource($item);
    }

    public function register($request)
    {
        Admin::query()->create($request->validated());
        return 'Account created successfully';
    }

    public function forgetPassword($request)
    {
        DB::beginTransaction();
        if($request->filled('email')) $item = Admin::query()->firstWhere('email', $request->email);
        else if($request->filled('code')) $item = Admin::query()->firstWhere('code', $request->code);
        $forget_password_code = randomStr();
        $item->update(['forget_password_code' => $forget_password_code]);
        DB::commit();
        return $item;
    }

    public function resetPassword($request)
    {
        DB::beginTransaction();
        $item = Admin::query()->firstWhere('forget_password_code', $request->forget_password_code);
        $item->update([
            'password' => $request->password,
            'forget_password_code' => null
        ]);
        $item->access_token = auth('admin')->attempt(['email' => $item->email, 'password' => $request->password], true);
        DB::commit();
        return new AdminResource($item);
    }

    public function profile()
    {
        return new AdminResource(auth('admin')->user());
    }

    public function generateUniqueCode()
    {
        while(1) {
            $code = randomStr();
            if(! Admin::where('code', $code)->count()) break;
        }
        return ['code' => $code];
    }
}