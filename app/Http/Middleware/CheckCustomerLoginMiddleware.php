<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('customer')->user()) {
            dd(Auth::guard('customer')->user());
            return redirect()->route('auth.login')->with('middlewareMessage', 'Bạn cần đăng nhập để thực hiện chức năng này!');
        }
        return $next($request);
    }
}
