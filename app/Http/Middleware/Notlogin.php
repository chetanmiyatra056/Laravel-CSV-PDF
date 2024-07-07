<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Frontend\LoginController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class Notlogin
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
        if(session()->has("email") == null){
            return $next($request);
        }else{
            return redirect("/");
            // Route::get("/login", [LoginController::class, "login"])->name("login");
        }
    }
}
