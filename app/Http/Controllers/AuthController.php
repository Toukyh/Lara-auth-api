<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function Register(Request $request)
    {
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);
    }

    public function Login(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()){
            return $validator->errors();
        }else
        if (!Auth::attempt($request->all())) {
            return response([
                'message' => 'invalid credentials'
            ],401);
        }else{
            $token = Auth::user()->createToken('token')->plainTextToken;
        }

        return response([
            "token" => $token
        ]);
    }

    public function Authenticated()
    {
        return Auth::user();
    }

    public function signOut()
    {
        return response([
            "msg" => "you are loged out"
        ]);
    }
}
