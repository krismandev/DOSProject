<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Utilities\ResponseMessage;
use App\Utilities\ResponseUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            "kode","password"
        ]);
        $creds = $request->only(['kode','password']);
        if ($token = JWTAuth::attempt($creds)){
            $user = Auth::user();
            $data = [
                "token"=>$token,
                "user"=>$user
            ];
            $message = ResponseMessage::SUCCESS;
            return ResponseUtility::makeResponse($data,$message,200);
        }else{
            $message = ResponseMessage::INVALID_CREDENTIAL;
            return ResponseUtility::makeResponse(null,$message,200);
        }

    }
}
