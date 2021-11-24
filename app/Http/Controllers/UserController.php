<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Department;
use App\Models\DepartmentUser;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        $employees = User::where('role', 2)->get();
        $departments = Department::all();
        return view('dashboard.employees', \compact('employees','departments'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'department' => 'required',
            'email' => 'required'
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Please enter all details');
            return \redirect()->back();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('1234')
        ]);

        DepartmentUser::create([
            'user_id' => $user->id,
            'department_id' => $request->department
        ]);

        session()->flash('success','Employee added');

        return \redirect()->back();
    }
}
