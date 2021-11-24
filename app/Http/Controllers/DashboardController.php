<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index(){    
        $employees = User::where('role', 2)->get();

        return view('dasboard.index', \compact('employees'));
    }
}
