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
Route::get('/fetch-students', [App\Http\Controllers\StudentController::class, 'fetchStudents'])->name('fetch-students');
Route::get('/edit-students/{id}', [App\Http\Controllers\StudentController::class, 'editStudents'])->name('edit-students');
Route::put('/update-students/{id}', [App\Http\Controllers\StudentController::class, 'updateStudents'])->name('update-students');
Route::delete('/delete-student/{id}', [App\Http\Controllers\StudentController::class, 'deleteStudents'])->name('delete-students');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
