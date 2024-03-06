<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\AppBaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreUserRequest;




class UserController extends AppBaseController
{
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::get();
        return $this->sendResponse($data,'retreived data successfully');
    }

 
    public function store(StoreUserRequest $request)
    {
        $data = $request->all();

        $data['password'] = bcrypt($data['password']);
        $userEmail = User::where('user_email',$data['user_email'])->first();
        if($userEmail){
            return $this->sendFailResponse("Email ".$data['user_email']." already exists");   
        }
        $user = User::create($data);
        if($user){
            return $this->sendResponse($data,'Created user successfully');   
        }
        return $this->sendFailResponse('Created user failed');
    }

    public function show($id)
    {
        $data = User::find($id);
        return $this->sendResponse($data,'Show data user');   
    }

    public function update(UpdateUserRequest $request)
    {
        $data = $request->all();

        $user = User::where('user_id',$data['user_id'])->first();
        $user->user_fullname = $data['user_fullname'];
        $user->user_email = $data['user_email'];
        if($data['password']){
            $user->password = bcrypt($data['password']);   
        }
        $user->update();
        if($user){
            return $this->sendResponse($data,'Updated user successfully');   
        }
        return $this->sendFailResponse('Updated user failed');
    }

    public function destroy($id)
    {

        $user = User::where('user_id',$id)->first();
        if(!$user){
            return $this->sendFailResponse('id not found');
        }
        User::where('user_id',$id)->delete();
        return $this->sendMessageResponse('deleted user successfully');   

    }
    public function totalCount()
    {
        $user = User::count();
        $userOnline = User::where('user_status',1)->count();
        return $this->sendResponse(["total"=>$user,"online"=>$userOnline],'retreived user successfully');   

    }
}
