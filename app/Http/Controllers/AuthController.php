<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\MailController;
use App\Models\Task;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $this->taskAnalysis();
            
            return redirect()->intended('dashboard');
        }

        session()->flash('error', 'Please enter correct credentials');

        return \redirect()->back();
    }

    public function resetPassword(Request $request){
        User::where('id', Auth::id())->update(
            [
                'password' => Hash::make($request->password),
                'password_updated' => true
            ]
        );

        session()->flash('success', 'Password updated!');
        return redirect()->back();
    }

    public function taskAnalysis(){
        //get in progress tasks
        $progressTasks = Task::where('status',1)->with('user')->get();

        //get manager email
        $email = User::where('role', 1)->pluck('email')->first();

        $overdueTasks = [];

        //check tasks that have passed time
        foreach ($progressTasks as $task) {
           if(Carbon::parse($task->end_date)->isPast()){
               array_push($overdueTasks, $task);
           }
        }

        //send mail for each overdue task
        if (count($overdueTasks) > 0) {
            foreach ($overdueTasks as $t) {
                $mailController = new MailController();
                $mailController->index(null, $t->user->email,$email,'Task overdue', $t->task_name.' is overdue. Please review.');
            }
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
