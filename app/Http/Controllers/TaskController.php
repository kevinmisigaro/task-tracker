<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::with('users')->get();
        $employees = User::where('role', 2)->get();
        return view('dashboard.tasks', \compact('tasks','employees'));
    }
}
