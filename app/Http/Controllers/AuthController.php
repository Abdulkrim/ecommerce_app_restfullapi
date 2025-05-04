<?php

namespace App\Http\Controllers;

use App\Mail\VerifyCodeMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //  انشاء مستخدم جديد
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:100|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $verifyCode = rand(10000, 99999);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'verifycode' => $verifyCode,
        ]);

        Mail::to($user->email)->send(new VerifyCodeMail($verifyCode));

        return response()->json([
            'status'=> true,
            'message' => 'Verification code sent to your email',
            // 'user' => $user,
        ], 201);
    }


    // verification code
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'verifycode' => 'required|numeric',
        ]);

        $user = User::where('email', $request->email)
            ->where('verifycode', $request->verifycode)
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid verification code or email'], 400);
        }

        $user->is_verified = true;
        $user->verifycode = null;
        $user->save();

        return response()->json([
            'status'=> true,
            'message' => 'Account verified successfully',
        ], 200);
    }


    // دالة تسجيل الدخول
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        if (!$user->is_verified) {
            return response()->json(['message' => 'Please verify your account first'], 403);
        }
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ], 200);
    }
    
}
