<?php

namespace zedsh\zadmin\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use zedsh\zadmin\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{

    public function showRegistrationForm()
    {
        return view('zadmin::pages.registration.index');
    }


    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->fill($request->only('name','email','password')->toArray());
        $user->password = Hash::make($user->password);
        $user->saveOrFail();

        return redirect(route('login'));
    }
}
