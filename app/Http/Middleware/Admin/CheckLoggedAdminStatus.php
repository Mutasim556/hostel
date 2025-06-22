<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckLoggedAdminStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('admin')->user()->status==0 || Auth::guard('admin')->user()->delete==1){
            Auth::guard('admin')->logout();
            return to_route('admin.login')->with('login_first',__('admin_local.Your account has been suspended . Please contact with super admin'));
        }
        return $next($request);
    }
}
