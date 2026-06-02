<?php

use App\Http\Controllers\SignInController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\GradeLevelController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SettingRoleController;
use App\Http\Controllers\SettingUserController;
use App\Http\Controllers\SubjectCategoryController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SignInController::class, 'show'])->middleware('guest')->name('signin');
Route::post('/signin', [SignInController::class, 'store'])->middleware('guest')->name('signin.store');

Route::get('/signin', fn () => redirect()->route('signin'))->middleware('guest');

Route::get('/dashboard', function(){
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')
    ->prefix('configuration/curriculum')
    ->name('configuration.curriculum.')
    ->group(function () {
        Route::get('/grade-level', [GradeLevelController::class, 'index'])->name('grade-level');
        Route::post('/grade-level', [GradeLevelController::class, 'store'])->name('grade-level.store');
        Route::put('/grade-level/{gradeLevel}', [GradeLevelController::class, 'update'])->name('grade-level.update');
        Route::delete('/grade-level/{gradeLevel}', [GradeLevelController::class, 'destroy'])->name('grade-level.destroy');
        Route::get('/academic-year', [AcademicYearController::class, 'index'])->name('academic-year');
        Route::post('/academic-year', [AcademicYearController::class, 'store'])->name('academic-year.store');
        Route::put('/academic-year/{academicYear}', [AcademicYearController::class, 'update'])->name('academic-year.update');
        Route::delete('/academic-year/{academicYear}', [AcademicYearController::class, 'destroy'])->name('academic-year.destroy');
        Route::get('/class', [SchoolClassController::class, 'index'])->name('class');
        Route::post('/class', [SchoolClassController::class, 'store'])->name('class.store');
        Route::put('/class/{schoolClass}', [SchoolClassController::class, 'update'])->name('class.update');
        Route::delete('/class/{schoolClass}', [SchoolClassController::class, 'destroy'])->name('class.destroy');
        Route::post('/class/{schoolClass}/subjects', [SchoolClassController::class, 'storeSubject'])->name('class.subjects.store');
        Route::delete('/class-subjects/{classSubject}', [SchoolClassController::class, 'destroySubject'])->name('class.subjects.destroy');
        Route::get('/subject-category', [SubjectCategoryController::class, 'index'])->name('subject-category');
        Route::post('/subject-category', [SubjectCategoryController::class, 'store'])->name('subject-category.store');
        Route::put('/subject-category/{subjectCategory}', [SubjectCategoryController::class, 'update'])->name('subject-category.update');
        Route::delete('/subject-category/{subjectCategory}', [SubjectCategoryController::class, 'destroy'])->name('subject-category.destroy');
        Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects');
        Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
        Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
        Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
    });

Route::middleware('auth')
    ->prefix('configuration/accounts')
    ->name('configuration.accounts.')
    ->group(function () {
        Route::get('/students', [StudentController::class, 'index'])->name('students');
        Route::post('/students', [StudentController::class, 'store'])->name('students.store');
        Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
        Route::post('/students/{student}/reset-password', [StudentController::class, 'resetPassword'])->name('students.reset-password');
        Route::get('/guardians', [GuardianController::class, 'index'])->name('guardians');
        Route::post('/guardians', [GuardianController::class, 'store'])->name('guardians.store');
        Route::put('/guardians/{guardian}', [GuardianController::class, 'update'])->name('guardians.update');
        Route::delete('/guardians/{guardian}', [GuardianController::class, 'destroy'])->name('guardians.destroy');
        Route::post('/guardians/{guardian}/reset-password', [GuardianController::class, 'resetPassword'])->name('guardians.reset-password');
        Route::post('/guardians/{guardian}/childs', [GuardianController::class, 'storeChild'])->name('guardians.childs.store');
        Route::delete('/guardian-childs/{guardianChild}', [GuardianController::class, 'destroyChild'])->name('guardians.childs.destroy');
        Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers');
        Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store');
        Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->name('teachers.update');
        Route::post('/teachers/{teacher}/reset-password', [TeacherController::class, 'resetPassword'])->name('teachers.reset-password');
        Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
    });

Route::middleware('auth')
    ->prefix('configuration/setting')
    ->name('configuration.setting.')
    ->group(function () {
        Route::get('/users', [SettingUserController::class, 'index'])->name('users');
        Route::post('/users', [SettingUserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [SettingUserController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/reset-password', [SettingUserController::class, 'resetPassword'])->name('users.reset-password');
        Route::delete('/users/{user}', [SettingUserController::class, 'destroy'])->name('users.destroy');
        Route::get('/roles', [SettingRoleController::class, 'index'])->name('roles');
        Route::post('/roles', [SettingRoleController::class, 'store'])->name('roles.store');
        Route::put('/roles/{role}', [SettingRoleController::class, 'update'])->name('roles.update');
        Route::post('/roles/{role}/permissions/sync', [SettingRoleController::class, 'syncPermissions'])->name('roles.permissions.sync');
        Route::delete('/roles/{role}/permissions/{permission}', [SettingRoleController::class, 'destroyPermission'])->name('roles.permissions.destroy');
        Route::delete('/roles/{role}', [SettingRoleController::class, 'destroy'])->name('roles.destroy');
    });

Route::post('/logout', [SignInController::class, 'destroy'])->middleware('auth')->name('logout');
