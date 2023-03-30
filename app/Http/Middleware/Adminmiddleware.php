<?php

namespace App\Http\Middleware;
use Auth;
use Closure;
use Illuminate\Http\Request;

class Adminmiddleware
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
        if (Auth::check()){

            //admin role
            if(Auth::user()->Role == 1) {
                return $next($request);
            }
            else{
                return redirect('/accessdenied')->with('message','Access denied as you are not admin!');
            }
        }
        else {
            return redirect('/login')->with('message','Login to access website info!');
        }
        return $next($request);
    }
}