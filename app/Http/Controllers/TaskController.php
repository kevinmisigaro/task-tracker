<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(){
        $tasks = Task::with('user')->get();
        $employees = User::where('role', 2)->get();
        return view('dashboard.tasks', \compact('tasks','employees'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'employee' => 'required'
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Please enter all details');
            return \redirect()->back();
        }

        Task::create([
            'task_name' => $request->name,
            'user_id' => $request->employee,
            'start_date' => $request->startdate,
            'end_date' => $request->enddate,
        ]);

        session()->flash('success','Task saved');
        return redirect()->back();
    }

    public function employeeCompleteTask(Request $request){
        $validator = Validator::make($request->all(), [
            'task' => 'required',
            'report' => 'required'
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Please enter all details');
            return \redirect()->back();
        }

        Task::where('id', $request->task)->update([
            'report' => $request->report,
            'status' => 3
        ]);

        //send mail to manager

        session()->flash('success','Task marked as complete');
        return \redirect()->back();
    }

    public function managerReviewTask(Request $request){
        $validator = Validator::make($request->all(), [
            'task' => 'required',
            'comment' => 'required',
            'type' => 'required'
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Please enter all details');
            return \redirect()->back();
        }

        $task =  Task::where('id', $request->task)->first();

        $task->update([
            'comment' => $request->comment,
            'end_date' => ($request->type == 2) ? $request->newdate : $task->end_date
        ]);

        session()->flash('success','Task accepted as complete');
        return \redirect()->back();

    }
}
