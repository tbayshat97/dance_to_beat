<?php

namespace App\Http\Controllers\Artist\Auth;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view('backend-artist.auth.forgot-password');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'username' => 'required|email|exists:artists',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->username,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('vendor.notifications.artist-email', ['token' => $token], function ($message) use ($request) {
            $message->to($request->username);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm($token)
    {
        return view('backend-artist.auth.reset', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'username' => 'required|email|exists:artists',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->username,
                'token' => $request->token
            ])
            ->count();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $artist =  Artist::where('username', $request->username)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->username])->delete();

        return redirect()->route('artist.login_form')->with('message', 'Your password has been changed!');
    }
}
