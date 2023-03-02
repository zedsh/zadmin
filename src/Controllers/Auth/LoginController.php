<?php

namespace zedsh\zadmin\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use zedsh\zadmin\Http\Requests\LoginRequest;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('zadmin::pages.authorization.index');
    }


    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = null;
        if(!empty($credentials['remember'])) {
            $remember = true;
            unset($credentials['remember']);
        }

        if (Auth::attempt($credentials)) {
            $user = User::where('email','=',$credentials['email'])->firstOrFail();
            Auth::login($user, $remember);
            request()->session()->regenerate();

            return redirect()->route('admin');
        }
    }

    public function logout() {
        Auth::logout();
        request()->session()->regenerate();

        return redirect()->route('login');
    }
}
