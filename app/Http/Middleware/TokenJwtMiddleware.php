<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenJwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try{
            JWTAuth::parseToken()->authenticate();
            
        }catch(Exception $exception){
            if($exception instanceof TokenExpiredException){
                return response()->json([
                    'status' => false,
                    'message' => 'Token JWT expired.',
                ],401);
            }
            if($exception instanceof TokenInvalidException){
            return response()->json([
                'status' => false,
                'message' => 'Invalid token JWT, please try again login to BaldeCash.',
            ],401);
            }

            return response()->json([
                'status' => false,
                'message' => 'Token JWT not send.',
            ],401);
        }
        
        return $next($request);
        
    }
}
