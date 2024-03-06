<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\AppBaseController;
use App\Http\Requests\LoginRequest;

use App\Models\User;



class AuthController extends AppBaseController
{
    
    public function login(LoginRequest $request){

        if (! $token = auth()->attempt($request->validated())) {
            return response()->json(['error' => 'Email and password wrong'], 401);
        }
        User::where('user_email',$request->user_email)->update(['user_status' => 1]);

        return $this->sendResponse(["token" => $token],"Authentication success");
    }
    public function logout() {
        User::where('user_email',auth()->user()->user_email)->update(['user_status' => 0]);
        auth()->logout();
        return $this->sendMessageResponse('User successfully signed out');   
    }
    public function userProfile() {
        return response()->json(auth()->user());
    }

}
