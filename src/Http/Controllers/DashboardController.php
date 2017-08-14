<?php

namespace Studio\Totem\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route('totem.tasks.all');
        //        return view('totem::dashboard');
    }
}
