<?php

namespace App\Http\Middleware;

use Closure;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty($request->header("X-CSRF"))) {
            return response()->json([
                "status" => 400,
                "error" => "Bad Request, Authentication Header not found",
            ]);
        }
        return $next($request);
    }
}
