<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index(){
        $departments = Department::withCount('users')->get();
        return view('dashboard.departments', \compact('departments'));
    }
}
