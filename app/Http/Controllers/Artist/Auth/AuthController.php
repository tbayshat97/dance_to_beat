<?php

namespace App\Http\Controllers\Artist\Auth;

use App\Enums\ArtistStatus;
use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:artist')->except('logout');
    }

    public function showLoginForm()
    {
        $pageConfigs = ['bodyCustomClass' => 'login-bg', 'isCustomizer' => false];
        return view('backend-artist.auth.login', ['pageConfigs' => $pageConfigs]);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:6'
        ]);


        $artist = Artist::where('username', $request->username)->first();

        if ($artist && $artist->status == ArtistStatus::Suspended) {
            $errors = [
                'username' => 'Sorry your account has been suspended',
            ];

            return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors($errors);
        }

        if ($artist && $artist->status == ArtistStatus::Blocked) {
            $errors = [
                'username' => 'Your account has been temporarily locked',
            ];

            return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors($errors);
        }

        // Attempt to log the user in
        if (Auth::guard('artist')->attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('artist.dashboard'));
        }

        $errors = [
            'username' => 'username or password is incorrect',
        ];

        return redirect()->back()->withInput($request->only('username', 'remember'))->withErrors($errors);
    }

    public function logout(Request $request)
    {
        auth('artist')->logout();
        $request->session()->invalidate();
        return redirect(route('artist.login_form'));
    }
}
