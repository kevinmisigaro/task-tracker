<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }

        session()->flash('error', 'Please enter correct credentials');

        return \redirect()->back();
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}
