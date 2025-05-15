<?php

namespace App\Http\Controllers;

use App\Mail\VerifyCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordController extends Controller
{

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $verifyCode = rand(10000, 99999);
        $user->verifycode = $verifyCode;
        $user->save();

        Mail::to($user->email)->send(new VerifyCodeMail($verifyCode));

        return response()->json([
            'status' => true,
            'message' => 'Verification code sent to your email',
        ], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|exists:users,email',
             'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();


        return response()->json([
            'status' => true,
            'message' => 'Password has been reset successfully.',
        ], 200);
    }
}
