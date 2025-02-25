<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\HomeController; 

class SetLanguage
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

        if ($request->language) {
            \App::setLocale($request->language);
            session()->put('lang', $request->language);
        }
        
        return $next($request);
    }
}
