<?php

namespace Modules\Website\User\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Website\User\Entities\Client;
use Modules\Website\User\Transformers\ClientResource;

class AuthRepository
{
    public function login($request)
    {
        if($request->filled('email')) {
            $credentials = $request->only(['email', 'password']);
            $item = Client::query()->firstWhere('email', $request->email);
        } else if($request->filled('code')) {
            $credentials = $request->only(['code', 'password']);
            $item = Client::query()->firstWhere('code', $request->code);
        }
        if (!$item['access_token'] = Auth::guard('client')->attempt($credentials, true)) throw new \Exception('The email or code or password you entered is invalid.', 401);
        return new ClientResource($item);
    }

    public function register($request)
    {
        Client::query()->create($request->validated());
        return 'Account created successfully';
    }

    public function forgetPassword($request)
    {
        DB::beginTransaction();
        if($request->filled('email')) $item = Client::query()->firstWhere('email', $request->email);
        else if($request->filled('code')) $item = Client::query()->firstWhere('code', $request->code);
        $forget_password_code = randomStr();
        $item->update(['forget_password_code' => $forget_password_code]);
        DB::commit();
        return $item;
    }

    public function resetPassword($request)
    {
        DB::beginTransaction();
        $item = Client::query()->firstWhere('forget_password_code', $request->forget_password_code);
        $item->update([
            'password' => $request->password,
            'forget_password_code' => null
        ]);
        $item->access_token = auth('admin')->attempt(['email' => $item->email, 'password' => $request->password], true);
        DB::commit();
        return new ClientResource($item);
    }

    public function profile()
    {
        return new ClientResource(auth('client')->user());
    }

    public function generateUniqueCode()
    {
        while(1) {
            $code = randomStr();
            if(! Client::where('code', $code)->count()) break;
        }
        return ['code' => $code];
    }
}