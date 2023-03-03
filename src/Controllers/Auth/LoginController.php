<?php

namespace zedsh\zadmin\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use zedsh\zadmin\Http\Requests\LoginRequest;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('zadmin::pages.authorization.index');
    }


    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email','password'), !empty($request->only('remember')))) {
            return redirect()->route('admin');
        }

        return redirect()->back()->withErrors([
            'msg'=>'Такого пользователя не существует.'
        ]);
    }

    public function logout() {
        Auth::logout();

        return redirect()->route('login');
    }
}
