<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\User;
use App\Helper\ApiHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Guard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return ApiHelper::response('false', 'input tidak valid', $validator->errors(), 401);
            }
            $credentials = $validator->validated();
            if (Auth::attempt($credentials)) {
                $user = User::firstWhere('email', $credentials['email']);
                $guard = $user->data_guard;
                if (!$guard) {
                    return ApiHelper::response('false', 'Info login tidak valid', $credentials, 401);
                }
                $guard['token'] = $user->createToken('auth_token')->plainTextToken;
                return ApiHelper::response('true', 'login berhasil', $guard, 200);
            }

            return ApiHelper::response('false', 'Info login tidak valid', $credentials, 401);
        } catch (Throwable $e) {
            Log::debug('AuthController login() ' . $e->getMessage());
            return ApiHelper::response('false', 'terjadi masalah', [$e->getMessage()], 500);
        }
    }

    public function me(Request $request)
    {
        $user_id = $request->user()->id;
        return User::find($user_id)->data_guard;
    }
}