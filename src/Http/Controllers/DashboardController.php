<?php

namespace Studio\Totem\Http\Controllers;

class DashboardController extends Controller
{
    /**
     * Single page application catch-all route.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('totem.tasks.all');
    }
}
