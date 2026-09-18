<?php

use App\Http\Controllers\PortalAuthController;
use App\Http\Controllers\PortalPageController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TeacherGradeController;
use App\Http\Controllers\PortalGradeController;
use Illuminate\Support\Facades\Route;

Route::get('/portal/{portal}/login', [PortalAuthController::class, 'show'])
    ->whereIn('portal', ['teacher', 'student', 'guardian'])->name('portal.login');
Route::post('/portal/{portal}/login', [PortalAuthController::class, 'store'])
    ->whereIn('portal', ['teacher', 'student', 'guardian'])->middleware('throttle:5,1')->name('portal.login.store');
Route::post('/portal/{portal}/logout', [PortalAuthController::class, 'destroy'])
    ->whereIn('portal', ['teacher', 'student', 'guardian'])->name('portal.logout');

Route::get('/portal/{portal}/register', [RegistrationController::class, 'show'])
    ->whereIn('portal', ['student', 'guardian'])->name('portal.register');
Route::post('/portal/{portal}/register', [RegistrationController::class, 'store'])
    ->whereIn('portal', ['student', 'guardian'])->middleware('throttle:10,1')->name('portal.register.store');
Route::get('/portal/{portal}/register/success', [RegistrationController::class, 'success'])
    ->whereIn('portal', ['student', 'guardian'])->name('portal.registration.success');
Route::view('/terms-of-use', 'legal.document', ['document' => 'terms'])->name('legal.terms');
Route::view('/privacy-notice', 'legal.document', ['document' => 'privacy'])->name('legal.privacy');

Route::prefix('teacher')->middleware('portal:teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [PortalPageController::class, 'teacher'])->name('home');
    Route::get('/classes', fn () => redirect()->route('teacher.subjects'))->name('classes.legacy');
    Route::get('/subjects', [TeacherGradeController::class, 'index'])->name('subjects');
    Route::get('/subjects/{classSubject}/students', [TeacherGradeController::class, 'students'])->name('subjects.students');
    Route::get('/advisory-class', [PortalPageController::class, 'advisoryClass'])->name('advisory-class');
    Route::get('/grades', [TeacherGradeController::class, 'gradeIndex'])->name('grades.index');
    Route::get('/grade-history', [PortalPageController::class, 'history'])->name('history');
    Route::get('/profile', [PortalPageController::class, 'profile'])->name('profile');
    Route::post('/profile', [PortalPageController::class, 'updateProfile'])->name('profile.update');
    Route::get('/subjects/{classSubject}/grades', [TeacherGradeController::class, 'show'])->name('grades');
    Route::post('/subjects/{classSubject}/grades', [TeacherGradeController::class, 'store'])->name('grades.store');
    Route::get('/subjects/{schoolClass}/{subject}/grades', [TeacherGradeController::class, 'legacyGradeRoute'])->name('grades.legacy');
    Route::post('/subjects/{schoolClass}/{subject}/grades', [TeacherGradeController::class, 'legacyGradeStore'])->name('grades.legacy.store');
});
Route::prefix('student')->middleware('portal:student')->name('student.')->group(function () {
    Route::get('/dashboard', [PortalPageController::class, 'student'])->name('home');
    Route::get('/grades', [PortalGradeController::class, 'student'])->name('grades');
    Route::get('/subjects', [PortalPageController::class, 'subjects'])->name('subjects');
    Route::get('/profile', [PortalPageController::class, 'profile'])->name('profile');
    Route::post('/profile', [PortalPageController::class, 'updateProfile'])->name('profile.update');
});
Route::prefix('guardian')->middleware('portal:guardian')->name('guardian.')->group(function () {
    Route::get('/dashboard', [PortalPageController::class, 'guardian'])->name('home');
    Route::get('/children', [PortalGradeController::class, 'children'])->name('children');
    Route::get('/grades', fn () => redirect()->route('guardian.children'))->name('grades.index');
    Route::get('/children/{student}', [PortalGradeController::class, 'child'])->name('grades');
    Route::get('/profile', [PortalPageController::class, 'profile'])->name('profile');
    Route::post('/profile', [PortalPageController::class, 'updateProfile'])->name('profile.update');
});
