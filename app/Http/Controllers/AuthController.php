<?php

namespace App\Http\Controllers;
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

   
       $user = User::create([
           'name' => $request->name,
           'email' => $request->email,
           'phone' => $request->phone,
           'password' => Hash::make($request->password),
       ]);

    
       return response()->json([
           'message' =>  'user_created_successfully',
           'user' => $user,
       ], 201);
   }

   // دالة تسجيل الدخول
   public function login(Request $request)
   {
       $request->validate([
           'email' => 'required|string|email',
           'password' => 'required|string',
       ]);

       $user = User::where('email', $request->email)->first();

       if (!$user || !Hash::check($request->password, $user->password)) {
           return response()->json(['message' => 'messages.invalid_credentials'], 401);
       }
       // حذف التوكنات القديمة قبل إنشاء توكن جديد
       // $user->tokens()->delete();
       //حذف التوكن الحالي قبل إنشاء توكن جديد
       // $user->currentAccessToken()->delete();

       $token = $user->createToken('auth_token')->plainTextToken;

       return response()->json(['message'=>__('messages.login'),'token' => $token], 200);
   }

   /**
    * Display a listing of the resource.
    */
   public function index()
   {
       return User::with('posts')->get();
   }

   /**
    * Display the specified resource.
    */
   public function show(string $id)
   {
       return User::findOrFail($id);
   }

   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id)
   {
       $user = User::findOrFail($id);
       $user->update($request->all());

       return response()->json($user, 200);
   }

   /**
    * Remove the specified resource from storage.
    */
   public function destroy(string $id)
   {
       User::destroy($id);

       return response()->json(['message' => 'messages.user_deleted_successfully'], 204);
   }
}
