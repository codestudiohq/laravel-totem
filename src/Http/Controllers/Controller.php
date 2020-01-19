<?php

namespace Studio\Totem\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Studio\Totem\Http\Middleware\Authenticate;

class Controller extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(Authenticate::class);
    }
}
