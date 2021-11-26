<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\DepartmentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
    return view('login');
})->name('login');

Route::post('loginUser',[AuthController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    Route::post('passwordUpdate',[AuthController::class,'resetPassword']);

    Route::prefix('employees')->group(function(){
        Route::get('/', [UserController::class, 'index']);
        Route::post('store', [UserController::class, 'store']); 
        Route::post('update/{id}', [UserController::class, 'update']);
        Route::delete('delete/{id}', [UserController::class, 'delete']);   
    });

    Route::prefix('tasks')->group(function(){
        Route::get('/',[TaskController::class,'index']);
        Route::post('store', [TaskController::class, 'store']);   
        Route::post('review', [TaskController::class, 'managerReviewTask']);
        Route::post('submit', [TaskController::class, 'employeeCompleteTask']);
    });

    Route::prefix('departments')->group(function(){
        Route::get('/',[DepartmentController::class,'index']);
        Route::post('store', [DepartmentController::class, 'store']);   
    });

    Route::get('/logout',[AuthController::class, 'logout']);
});
