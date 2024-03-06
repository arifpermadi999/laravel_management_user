<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Response;


class AppBaseController extends Controller
{
   
    public function sendResponse($result, $message)
    {
        return Response::json($this->makeResponse($message, $result));
    }
    public function sendMessageResponse($message)
    {
        return Response::json($this->makeResponse($message));
    }
    public function sendFailResponse($message)
    {
        return Response::json([
                'success' => false,
                'message' => $message,
            ]);
    }
    public static function makeResponse($message, $data = [])
    {
        if($data){
            return [
                'success' => true,
                'data'    => $data,
                'message' => $message,
            ];
        }else{
            return [
                'success' => true,
                'message' => $message,
            ];
        }
    }
}
