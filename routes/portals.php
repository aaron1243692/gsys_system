<?php

use App\Http\Controllers\PortalAuthController;
use App\Http\Controllers\TeacherGradeController;
use App\Http\Controllers\PortalGradeController;
use Illuminate\Support\Facades\Route;

Route::get('/portal/{portal}/login', [PortalAuthController::class, 'show'])
    ->whereIn('portal', ['teacher', 'student', 'guardian'])->name('portal.login');
Route::post('/portal/{portal}/login', [PortalAuthController::class, 'store'])
    ->whereIn('portal', ['teacher', 'student', 'guardian'])->middleware('throttle:5,1')->name('portal.login.store');
Route::post('/portal/{portal}/logout', [PortalAuthController::class, 'destroy'])
    ->whereIn('portal', ['teacher', 'student', 'guardian'])->name('portal.logout');

// Frontend-only registration and legal pages. No registration POST route exists yet.
Route::view('/portal/{portal}/register', 'portal.registration')
    ->whereIn('portal', ['student', 'guardian'])->name('portal.register');
Route::view('/terms-of-use', 'legal.document', ['document' => 'terms'])->name('legal.terms');
Route::view('/privacy-notice', 'legal.document', ['document' => 'privacy'])->name('legal.privacy');

Route::prefix('teacher')->middleware('portal:teacher')->name('teacher.')->group(function () {
    Route::view('/dashboard', 'portal.teacher.dashboard', ['portal' => 'teacher'])->name('home');
    Route::get('/classes', [TeacherGradeController::class, 'index'])->name('classes');
    Route::view('/grades', 'portal.teacher.grades-index', ['portal' => 'teacher'])->name('grades.index');
    Route::view('/grade-history', 'portal.teacher.history', ['portal' => 'teacher'])->name('history');
    Route::view('/profile', 'portal.profile', ['portal' => 'teacher'])->name('profile');
    Route::get('/classes/{schoolClass}/subjects/{subject}/grades', [TeacherGradeController::class, 'show'])->name('grades');
    Route::post('/classes/{schoolClass}/subjects/{subject}/grades', [TeacherGradeController::class, 'store'])->name('grades.store');
});
Route::prefix('student')->middleware('portal:student')->name('student.')->group(function () {
    Route::view('/dashboard', 'portal.student.dashboard', ['portal' => 'student'])->name('home');
    Route::get('/grades', [PortalGradeController::class, 'student'])->name('grades');
    Route::view('/subjects', 'portal.student.subjects', ['portal' => 'student'])->name('subjects');
    Route::view('/profile', 'portal.profile', ['portal' => 'student'])->name('profile');
});
Route::prefix('guardian')->middleware('portal:guardian')->name('guardian.')->group(function () {
    Route::view('/dashboard', 'portal.guardian.dashboard', ['portal' => 'guardian'])->name('home');
    Route::get('/children', [PortalGradeController::class, 'children'])->name('children');
    Route::view('/grades', 'portal.guardian.grades-index', ['portal' => 'guardian'])->name('grades.index');
    Route::get('/children/{student}/grades', [PortalGradeController::class, 'child'])->name('grades');
    Route::view('/profile', 'portal.profile', ['portal' => 'guardian'])->name('profile');
});
