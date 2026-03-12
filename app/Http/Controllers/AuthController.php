<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    
    public function register(Request $request){
        $validated = $request->validate([
            'name'=>'required|string|max:40',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:4|max:15|confirmed',
        ]);
 
        // Always assign default role
        $role = Role::firstOrCreate(['name' => 'User']);
   
        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $role->id;
        $user->password = Hash::make($validated['password']);

        if($request->hasFile('user_image')){
           $user->user_image = $request->file('user_image')->store('users', 'public');
        }

        $user->save();

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message'=>'Registration successful. Please verify your email.'
            ], 201);
        }
    
     public function login(Request $request){
         $validated = $request->validate([
             'email'=>'required|email',
             'password'=>'required|string|min:4',
        ]);

         $user = User::where('email', $validated['email'])->first();

             if(!$user || !Hash::check($validated['password'], $user->password)){
             throw ValidationException::withMessages([
                'email'=> ['Invalid Credentials']
                ]);
            }

        if(!$user->hasVerifiedEmail()){
            return response()->json([
                'message'=>'Your account is not active, please verify your email first'
            ], 403);
        }         
    
         $token = $user->createToken("auth-token")->plainTextToken;

             return response()->json([
            'message'=>'Login Successful!',
            'token'=>$token,
            'user'=>$user,
            'abilities'=>$user->abilities(),
         ], 200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message'=>'Log out Successful'
            ]);
    }
}
