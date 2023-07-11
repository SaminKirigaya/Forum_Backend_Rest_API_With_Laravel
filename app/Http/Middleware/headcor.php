<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class headcor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        
    

        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin','*');
        $response->headers->set('Access-Control-Allow-Methods','GET, POST, PUT, DELETE');
        $response->headers->set('Access-Control-Allow-Headers','X-Requested-with, Content-Type, X-Token-Auth, Authorization');
        return $response;
    }
}
