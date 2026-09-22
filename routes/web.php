<?php

use App\Http\Controllers\SignInController;
use App\Http\Controllers\BatchController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\CurriculumSubjectController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\GradeLevelController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AccountReviewController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\EncodingScheduleController;
use App\Http\Controllers\GradeApprovalController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SettingRoleController;
use App\Http\Controllers\SettingUserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SubjectCategoryController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherLoadController;
use App\Models\AcademicYear;
use App\Models\GradeLevel;
use App\Models\SchoolClass;
use App\Models\StudentInfo;
use App\Models\StudentAccount;
use App\Models\Teacher;
use Illuminate\Support\Facades\Route;

Route::get('/', [SignInController::class, 'show'])->middleware('guest')->name('signin');
Route::post('/signin', [SignInController::class, 'store'])->middleware('guest')->name('signin.store');

Route::get('/signin', fn () => redirect()->route('signin'))->middleware('guest');

Route::get('/dashboard', \App\Http\Controllers\AdminDashboardController::class)->middleware('auth')->name('dashboard');

Route::middleware('auth')
    ->prefix('configuration/curriculum')
    ->name('configuration.curriculum.')
    ->group(function () {
        Route::get('/', [CurriculumController::class, 'index'])->name('index');
        Route::post('/', [CurriculumController::class, 'store'])->name('store');
        Route::get('/grade-level', [GradeLevelController::class, 'index'])->name('grade-level');
        Route::post('/grade-level', [GradeLevelController::class, 'store'])->name('grade-level.store');
        Route::put('/grade-level/{gradeLevel}', [GradeLevelController::class, 'update'])->name('grade-level.update');
        Route::delete('/grade-level/{gradeLevel}', [GradeLevelController::class, 'destroy'])->name('grade-level.destroy');
        Route::get('/batch', [BatchController::class, 'index'])->name('batch');
        Route::post('/batch', [BatchController::class, 'store'])->name('batch.store');
        Route::put('/batch/{batch}', [BatchController::class, 'update'])->name('batch.update');
        Route::delete('/batch/{batch}', [BatchController::class, 'destroy'])->name('batch.destroy');
        Route::get('/academic-year', [AcademicYearController::class, 'index'])->name('academic-year');
        Route::post('/academic-year', [AcademicYearController::class, 'store'])->name('academic-year.store');
        Route::put('/academic-year/{academicYear}', [AcademicYearController::class, 'update'])->name('academic-year.update');
        Route::delete('/academic-year/{academicYear}', [AcademicYearController::class, 'destroy'])->name('academic-year.destroy');
        Route::get('/class', [SchoolClassController::class, 'index'])->name('class');
        Route::post('/class', [SchoolClassController::class, 'store'])->name('class.store');
        Route::get('/class/{schoolClass}', [SchoolClassController::class, 'show'])->name('class.show');
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
        Route::get('/subject-map', [CurriculumSubjectController::class, 'index'])->name('subject-map');
        Route::get('/subject-map/load', [CurriculumSubjectController::class, 'load'])->name('subject-map.load');
        Route::post('/subject-map/{curriculum}', [CurriculumSubjectController::class, 'store'])->name('subject-map.store');
        Route::put('/{curriculum}', [CurriculumController::class, 'update'])->name('update');
        Route::delete('/{curriculum}', [CurriculumController::class, 'destroy'])->name('destroy');
    });

Route::middleware('auth')
    ->prefix('configuration/accounts')
    ->name('configuration.accounts.')
    ->group(function () {
        Route::get('/registrations', [AccountReviewController::class, 'index'])->name('registrations');
        Route::get('/registrations/{type}/{id}', [AccountReviewController::class, 'show'])->name('registrations.show');
        Route::post('/registrations/{type}/{id}', [AccountReviewController::class, 'update'])->name('registrations.update');
        Route::post('/registrations/students/{account}/link', [AccountReviewController::class, 'linkStudent'])->name('registrations.students.link');
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

Route::middleware('auth')
    ->prefix('academic')
    ->name('academic.')
    ->group(function () {
        Route::get('/schedule-load/class-schedule', [ClassScheduleController::class, 'index'])->name('schedule-load.class-schedule');
        Route::post('/schedule-load/class-schedule', [ClassScheduleController::class, 'store'])->name('schedule-load.class-schedule.store');
        Route::put('/schedule-load/class-schedule/{schoolClass}', [ClassScheduleController::class, 'update'])->name('schedule-load.class-schedule.update');
        Route::delete('/schedule-load/class-schedule/{schoolClass}', [ClassScheduleController::class, 'destroy'])->name('schedule-load.class-schedule.destroy');
        Route::post('/schedule-load/class-schedule/{schoolClass}/schedules', [ClassScheduleController::class, 'storeSchedule'])->name('schedule-load.class-schedule.schedules.store');
        Route::put('/schedule-load/class-schedule/schedules/{classSchedule}', [ClassScheduleController::class, 'updateSchedule'])->name('schedule-load.class-schedule.schedules.update');
        Route::delete('/schedule-load/class-schedule/schedules/{classSchedule}', [ClassScheduleController::class, 'destroySchedule'])->name('schedule-load.class-schedule.schedules.destroy');
        Route::get('/schedule-load/teacher-load', [TeacherLoadController::class, 'index'])->name('schedule-load.teacher-load');
        Route::post('/schedule-load/teacher-load', [TeacherLoadController::class, 'store'])->name('schedule-load.teacher-load.store');
        Route::put('/schedule-load/teacher-load/{classSubject}', [TeacherLoadController::class, 'update'])->name('schedule-load.teacher-load.update');
        Route::delete('/schedule-load/teacher-load/{classSubject}', [TeacherLoadController::class, 'destroy'])->name('schedule-load.teacher-load.destroy');
        Route::get('/schedule-load/rooms', [RoomController::class, 'index'])->name('schedule-load.rooms');
        Route::post('/schedule-load/rooms', [RoomController::class, 'store'])->name('schedule-load.rooms.store');
        Route::put('/schedule-load/rooms/{room}', [RoomController::class, 'update'])->name('schedule-load.rooms.update');
        Route::delete('/schedule-load/rooms/{room}', [RoomController::class, 'destroy'])->name('schedule-load.rooms.destroy');
        Route::get('/students', function () {
            $search = trim((string) request('search'));

            $students = StudentInfo::query()
                ->with(['academicYear', 'gradeLevel', 'schoolClass', 'student.portalAccount'])
                ->where('admited', 1)
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('lrn', 'like', "%{$search}%")
                            ->orWhere('lrn', 'like', "%{$search}%")
                            ->orWhereHas('student', fn ($studentQuery) => $studentQuery->where('student_number', 'like', "%{$search}%"))
                            ->orWhereHas('gradeLevel', fn ($gradeLevelQuery) => $gradeLevelQuery->where('name', 'like', "%{$search}%"))
                            ->orWhereHas('schoolClass', fn ($classQuery) => $classQuery->where('name', 'like', "%{$search}%"));
                    });
                })
                ->orderBy('name')
                ->paginate(10)
                ->withQueryString();

            return view('academic.students.students', [
                'students' => $students,
                'academicYears' => AcademicYear::query()->orderBy('year_from')->orderBy('name')->get(),
                'classes' => SchoolClass::query()->orderBy('name')->get(),
                'gradeLevels' => GradeLevel::query()->orderBy('name')->get(),
                'availableAccounts' => StudentAccount::whereNull('student_id')->orderBy('name')->orderBy('username')->get(),
                'search' => $search,
            ]);
        })->name('students.index');
        Route::put('/students/{studentInfo}', function (StudentInfo $studentInfo) {
            $validated = request()->validate([
                'lrn' => ['nullable', 'string', 'max:50'],
                'name' => ['required', 'string', 'max:150'],
                'gender' => ['nullable', 'string', 'max:20'],
                'birthdate' => ['nullable', 'date'],
                'grlvl_id' => ['nullable', 'integer', 'exists:grlvl,id'],
                'class_id' => ['nullable', 'integer', 'exists:class,id'],
                'acady_id' => ['nullable', 'integer', 'exists:acady,id'],
                'contact' => ['nullable', 'string', 'max:100'],
                'address' => ['nullable', 'string', 'max:255'],
            ]);

            $studentInfo->update($validated);

            $redirectRoute = request('redirect_to') === 'pre-enlistment'
                ? 'academic.students.pre-enlistment'
                : 'academic.students.index';

            return redirect()
                ->route($redirectRoute)
                ->with('success', 'Student updated successfully.');
        })->name('students.update');
        Route::delete('/students/{studentInfo}', function (StudentInfo $studentInfo) {
            $studentInfo->update(['admited' => 0]);

            $redirectRoute = request('redirect_to') === 'pre-enlistment'
                ? 'academic.students.pre-enlistment'
                : 'academic.students.index';

            return redirect()
                ->route($redirectRoute)
                ->with('success', 'Student deleted successfully.');
        })->name('students.destroy');
        Route::post('/students/{studentInfo}/admit', function (StudentInfo $studentInfo) {
            $validated = request()->validate([
                'lrn' => ['nullable', 'string', 'max:50'],
                'name' => ['required', 'string', 'max:150'],
                'gender' => ['nullable', 'string', 'max:20'],
                'birthdate' => ['nullable', 'date'],
                'grlvl_id' => ['nullable', 'integer', 'exists:grlvl,id'],
                'class_id' => ['nullable', 'integer', 'exists:class,id'],
                'acady_id' => ['nullable', 'integer', 'exists:acady,id'],
                'contact' => ['nullable', 'string', 'max:100'],
                'address' => ['nullable', 'string', 'max:255'],
            ]);

            \Illuminate\Support\Facades\DB::transaction(function () use ($studentInfo, $validated) {
                $studentInfo->update(array_merge($validated, ['admited' => 1]));
                $student = $studentInfo->student()->lockForUpdate()->firstOrFail();
                $student->forceFill(['status' => 'ACTIVE', 'activated_by' => auth()->id(), 'activated_at' => now()])->save();
                if ($account = $student->portalAccount()->lockForUpdate()->first()) {
                    $account->forceFill(['status' => 'ACTIVE', 'activated_by' => auth()->id(), 'activated_at' => now()])->save();
                    \App\Services\Audit::record('web', auth()->id(), 'student.pre_registration_approved', $account, ['student_id' => $student->id]);
                }
            });

            return redirect()
                ->route('academic.students.pre-enlistment')
                ->with('success', 'Student admitted and portal account activated successfully.');
        })->name('students.admit');
        Route::delete('/students/pre-enlistment/{studentInfo}', function (StudentInfo $studentInfo) {
            $studentInfo->delete();

            return redirect()
                ->route('academic.students.pre-enlistment')
                ->with('success', 'Pre-enlistment record deleted successfully.');
        })->name('students.pre-enlistment.destroy');
        Route::get('/students/pre-enlistment', function () {
            $search = trim((string) request('search'));

            $students = StudentInfo::query()
                ->with(['academicYear', 'gradeLevel', 'schoolClass', 'student.portalAccount'])
                ->pendingRegistration()
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('lrn', 'like', "%{$search}%")
                            ->orWhere('lrn', 'like', "%{$search}%")
                            ->orWhereHas('student', fn ($studentQuery) => $studentQuery->where('student_number', 'like', "%{$search}%"))
                            ->orWhereHas('gradeLevel', fn ($gradeLevelQuery) => $gradeLevelQuery->where('name', 'like', "%{$search}%"))
                            ->orWhereHas('schoolClass', fn ($classQuery) => $classQuery->where('name', 'like', "%{$search}%"));
                    });
                })
                ->orderBy('name')
                ->paginate(10)
                ->withQueryString();

            return view('academic.students.preenlistment', [
                'students' => $students,
                'academicYears' => AcademicYear::query()->orderBy('year_from')->orderBy('name')->get(),
                'classes' => SchoolClass::query()->orderBy('name')->get(),
                'gradeLevels' => GradeLevel::query()->orderBy('name')->get(),
                'search' => $search,
            ]);
        })->name('students.pre-enlistment');
    });

Route::middleware('auth')
    ->prefix('report')
    ->name('report.')
    ->group(function () {
        Route::get('/performance/top-student', [ReportController::class, 'topStudent'])->name('performance.top-student');
        Route::get('/performance/top-class', [ReportController::class, 'topClass'])->name('performance.top-class');
        Route::get('/grades', [\App\Http\Controllers\AdminGradeController::class, 'index'])->name('grades');
        Route::get('/grades/approval', [GradeApprovalController::class, 'index'])->name('grades.approval');
        Route::get('/grades/approval/{sheet}', [GradeApprovalController::class, 'show'])->name('grades.approval.show');
        Route::post('/grades/approval/{sheet}', [GradeApprovalController::class, 'update'])->name('grades.approval.update');
    });

Route::post('/logout', [SignInController::class, 'destroy'])->middleware('auth')->name('logout');

require __DIR__.'/portals.php';

Route::get('/configuration/grade-encoding-schedule', [EncodingScheduleController::class, 'index'])
    ->middleware('auth')
    ->name('configuration.grade-encoding-schedule');
Route::post('/configuration/grade-encoding-schedule', [EncodingScheduleController::class, 'store'])
    ->middleware('auth')
    ->name('configuration.grade-encoding-schedule.store');
