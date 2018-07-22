<?php

namespace Studio\Totem\Http\Middleware;

use Illuminate\Http\Request;
use Studio\Totem\Totem;

class Authenticate
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request, $next)
    {
        return Totem::check($request) ? $next($request) : abort(403);
    }
}
