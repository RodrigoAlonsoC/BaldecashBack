<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\AuthRequest;
use App\Http\Requests\Dashboard\RegisterUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(AuthRequest $request)
    {
        
        try{
            $jwt = JWTAuth::attempt($request->only('email','password'),false);
            if($jwt){
                return response()->json([
                    'status' => true,
                    'token' => compact('jwt'),  
                    'role' => Auth::user()->role, 
                ],200);
            }
        }catch(Exception $exception){
            return response()->json([
                'status' => false,
                'message' => 'Invalid Token.',
            ],500);
        }

        return response()->json([
            'status'=>false,
            'message' => 'Credentials wrong.'
        ],401);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerUser(RegisterUserRequest $request)
    {
        try{
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 0, // Defect in public
            ]);
    
            return response()->json([
                'status' => true,
                'user' => $user,
            ],200);
    
        }catch(Exception $exception){
            
            return response()->json([
                'status' => false,
                'message' => 'Error ocurred in transaction.',
                'tec' => $exception->getMessage(),
            ],500);
            
        }
    }

    
}
