<?php

namespace Studio\Totem\Http\Controllers;

class TasksController extends Controller
{
    public function index()
    {
        return view('totem::tasks.index');
    }

    public function create()
    {
        return view('totem::tasks.create');
    }
}
