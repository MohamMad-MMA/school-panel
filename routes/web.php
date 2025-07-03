<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return view('admin');
});
Route::prefix('admin')->group(function () {
    Route::resource('students', StudentController::class);
    Route::get('students/{student}/transcript', [StudentController::class, 'transcript'])->name('students.transcript');
});
Route::prefix('admin')->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('classes', SchoolClassController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('grades', GradeController::class);
});
Route::resource('admin/students', StudentController::class);
Route::get('admin/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('admin/students/{student}', [StudentController::class, 'update'])->name('students.update');
Route::delete('admin/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
Route::get('/students/{student}/transcript', [StudentController::class, 'transcript'])->name('students.transcript');
Route::post('/students/{student}/scores/{subject}', [StudentController::class, 'updateScore'])->name('students.updateScore');
Route::resource('admin/grades', GradeController::class);
Route::view('/admin', 'admin.index');
Route::resource('admin/subjects', SubjectController::class);
Route::resource('admin/teachers', TeacherController::class);
Route::resource('admin/classes', SchoolClassController::class);
Route::get('admin/students/{student}/transcript', [StudentController::class, 'transcript'])->name('students.transcript');
Route::post('admin/students/{student}/transcript/{subject}', [StudentController::class, 'storeScore'])->name('students.transcript.store');
Route::redirect('/', '/admin');
Route::resource('admin/school-classes', \App\Http\Controllers\SchoolClassController::class);
Route::get('admin/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->name('teachers.edit');
Route::put('admin/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
