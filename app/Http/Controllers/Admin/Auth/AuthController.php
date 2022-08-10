<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        $pageConfigs = ['bodyCustomClass' => 'login-bg', 'isCustomizer' => false];
        return view('backend.auth.login', ['pageConfigs' => $pageConfigs]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);

        // Attempt to log the user in
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        $errors = [
            'username' => 'username or password is incorrect',
        ];

        return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors($errors);
    }

    public function logout(Request $request)
    {
        auth::logout();
        $request->session()->invalidate();
        return redirect(route('admin.login_form'));
    }

    public function forgotPassword()
    {
        $pageConfigs = ['bodyCustomClass' => 'forgot-bg', 'isCustomizer' => false];
        return view('auth.forgot-password', compact('pageConfigs'));
    }
    public function lockScreen()
    {
        $pageConfigs = ['bodyCustomClass' => 'forgot-bg', 'isCustomizer' => false];

        return view('auth.lock-screen', compact('pageConfigs'));
    }
}
