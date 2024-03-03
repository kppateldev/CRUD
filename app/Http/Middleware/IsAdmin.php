<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use Redirect;
use Session;
use Carbon\Carbon;
use App\Models\VerificationCodeAdmin;

class IsAdmin
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

         if(auth()->guard('admin')->check())
        {
            return $next($request);
        
        }
        return redirect(route('admin.login'));
    }
}
