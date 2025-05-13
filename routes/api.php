<?php

use App\Http\Controllers\Courses\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
  //  return "welcome";
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [CourseController::class, 'create'])->name('login');
Route::get('/getusers', [CourseController::class, 'getusers'])->name('getusers');

//Route::middleware(['auth:sanctum'])->group(function () {
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {

  Route::get('/courses', [CourseController::class, 'Enrollcourses'])->name('courses');
  Route::get('/courses/{id}', [CourseController::class, 'courses'])->name('courses');
  Route::post('/courses/{id}/comments', [CourseController::class, 'addComment'])->name('courses');
  Route::get('/courses/{id}/comments', [CourseController::class, 'getComment'])->name('courses');
           


});
