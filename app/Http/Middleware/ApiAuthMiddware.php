<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');
        $authenticate = true;
// pastikan token ada
        if (!$token) {
            $authenticate = false; //jika token tidak ada, maka dia statuse false maka status tidak login
        }
// pastikan juga cek token di database dengan cara
// setelah sukses dapat usernya
        $user = User::where('token', $token)->first();
        if (!$user) {
            $authenticate = false;
        } else {
// lalu masukan ke auth login
            Auth::login($user);
        }
        //jika mau ngambil data user yang sedang login gampang banegt tinggal pakai ini
        // Auth::user(); pakai ini

        if ($authenticate) {
            return $next($request); // jika dia ter authenticate maka dia akan masuk ke controller selanjutnya
        } else {
            // jika tidak kita mau apa, disini kita akn mau return dengan response json berikut
            return response()->json([
                "errors" => [
                    "message" => [
                        "unauthorized",
                    ],
                ],
            ])->setStatusCode(401);
        }
    }
}
