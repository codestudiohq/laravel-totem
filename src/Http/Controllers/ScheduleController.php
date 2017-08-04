<?php

namespace Studio\Totem\Http\Controllers;

class ScheduleController extends Controller
{
    public function create()
    {
        return view('totem::schedule.create');
    }
}
