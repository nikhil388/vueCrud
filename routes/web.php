<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// Route::get('register',[App\Http\Controllers\HomeController::class, 'register'])->middleware('role');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('save_student', [App\Http\Controllers\StudentController::class, 'save_student'])->name('save_student');
Route::get('all_students', [App\Http\Controllers\StudentController::class, 'all_students']);
Route::get('edit_Student/{id}', [App\Http\Controllers\StudentController::class, 'edit_Students']);
Route::put('update_Student', [App\Http\Controllers\StudentController::class, 'update_Student']);
Route::delete('deleteStudent/{id}', [App\Http\Controllers\StudentController::class, 'deleteStudent']);
Route::post('/upload', [App\Http\Controllers\StudentController::class, 'upload'])->name('uploadImage');
Route::post('submitRating/{id}', [App\Http\Controllers\StudentController::class, 'submitRating'])->name('submitRating');




// all_students?page
