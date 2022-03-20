<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/student', [App\Http\Controllers\StudentController::class, 'index'])->name('student-dashboard');
Route::post('/create-student', [App\Http\Controllers\StudentController::class, 'store'])->name('create-student');
Route::get('/fetch-student', [App\Http\Controllers\StudentController::class, 'store'])->name('fetch-student');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
