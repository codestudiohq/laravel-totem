<?php

namespace Studio\Totem\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('totem::layout');
    }
}
