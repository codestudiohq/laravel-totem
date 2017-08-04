<?php

namespace Studio\Totem\Http\Middleware;

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
    public function handle($request, $next)
    {
        return Totem::check($request) ? $next($request) : abort(403);
    }
}
