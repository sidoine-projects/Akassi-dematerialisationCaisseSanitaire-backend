<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'token' => 'required',
        ]);

        // $resetStatus = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
        $resetStatus = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        if ($resetStatus === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password has been reset successfully'], 200);
        } else {
            return response()->json(['message' => 'Unable to reset password'], 400);
        }
    }
}
