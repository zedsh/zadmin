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

    public function showRegistrationForm(): Factory|View|Application
    {
        return view('zadmin::pages.registration.index');
    }


    public function register(RegisterRequest $request)
    {
        $newUser = $request->validated();
        $newUser['password'] = Hash::make($newUser['password']);
        $user = new User();
        $user->fill($newUser);
        $user->saveOrFail();

        return redirect(route('login'));
    }
}
