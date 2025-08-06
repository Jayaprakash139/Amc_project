<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;

class HomeController
{
    public function index()
    {
        $events = Task::whereNotNull('due_date')->get();
        return view('home',compact('events'));
    }
}
