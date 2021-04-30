<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Closure;
use Illuminate\Http\Request;

class TokenRuangHR
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $sended_token =  $request->header('hr_auth');

        $checkToken = Token::where('token','=',"$sended_token")
        ->where('access_type','!=',0)
        ->count();


        if ($checkToken <1) {
            return response()->json([
                'http_response' => 401,
                'status' => 0,
                'message' => 'API Token Tidak Sesuai, Silakan Request Token ke HR Terlebih Dahulu',
            ]);
        }else{
            return $next($request);
        }
        
    }
}
