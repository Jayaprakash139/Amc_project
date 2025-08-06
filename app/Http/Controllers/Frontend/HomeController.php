<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Task;

class HomeController
{
    public function index()
    {
        $events = Task::whereNotNull('due_date')->get();
        return view('frontend.home',compact('events'));
    }
}
