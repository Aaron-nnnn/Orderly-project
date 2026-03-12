<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function verify(Request $request, $id, $hash){
        $user = User::findorFail($id);

        if(!hash_equals((string) $hash, sha1($user->email))){
            return response()->json([
                'message'=>'Invalid Verification Link.'
            ], 403);
        }

        if($user->hasVerifiedEmail()){
            return response()->json([
                'message'=>'Email is already verified.'
            ], 200);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));
        return response()->json("Email Verified Successfully!");
    }
}
