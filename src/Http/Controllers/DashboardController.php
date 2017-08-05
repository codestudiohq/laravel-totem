<?php

namespace Studio\Totem\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('totem::dashboard');
    }
}
