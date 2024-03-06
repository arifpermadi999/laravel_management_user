<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\AppBaseController;
use App\Http\Requests\LoginRequest;

use App\Models\User;



class AuthController extends AppBaseController
{
    
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request){

        if (! $token = auth()->attempt($request->validated())) {
            return response()->json(['error' => 'Email and password wrong'], 401);
        }
        User::where('user_email',$request->user_email)->update(['user_status' => 1]);

        return $this->sendResponse(["token" => $token],"Authentication success");
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        User::where('user_email',auth()->user()->user_email)->update(['user_status' => 0]);
        auth()->logout();
        return $this->sendMessageResponse('User successfully signed out');   
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        
    }
}
