<?php

namespace App\Support;

use Illuminate\Http\Request;

final class WebPermissions
{
    /** @return array<string, string> */
    public static function routeMap(): array
    {
        return [
            'dashboard' => 'dashboard.view',
            'configuration.grade-encoding-schedule' => 'grades.schedule.view',
            'configuration.grade-encoding-schedule.store' => 'grades.schedule.create',
            'configuration.grade-encoding-schedule.update' => 'grades.schedule.update',
            'configuration.grade-encoding-schedule.destroy' => 'grades.schedule.delete',
            'configuration.setting.users' => 'users.view',
            'configuration.setting.users.store' => 'users.create',
            'configuration.setting.users.update' => 'users.update',
            'configuration.setting.users.reset-password' => 'users.reset_password',
            'configuration.setting.users.destroy' => 'users.delete',
            'configuration.setting.roles' => 'roles.view',
            'configuration.setting.roles.store' => 'roles.create',
            'configuration.setting.roles.update' => 'roles.update',
            'configuration.setting.roles.permissions.sync' => 'permissions.assign',
            'configuration.setting.roles.permissions.destroy' => 'permissions.assign',
            'configuration.setting.roles.destroy' => 'roles.delete',
            'configuration.accounts.registrations' => 'registrations.view',
            'configuration.accounts.registrations.show' => 'registrations.view',
            'configuration.accounts.registrations.update' => 'registrations.review',
            'configuration.accounts.registrations.students.link' => 'registrations.link_student',
            'configuration.accounts.guardians.childs.store' => 'guardian_children.add',
            'configuration.accounts.guardians.childs.destroy' => 'guardian_children.remove',
            'configuration.curriculum.class.subjects.store' => 'class_subjects.assign',
            'configuration.curriculum.class.subjects.destroy' => 'class_subjects.remove',
            'academic.students.index' => 'enrollments.view',
            'academic.students.update' => 'enrollments.update',
            'academic.students.destroy' => 'enrollments.delete',
            'academic.students.admit' => 'enrollments.admit',
            'academic.students.pre-enlistment' => 'enrollments.view',
            'academic.students.pre-enlistment.destroy' => 'enrollments.delete',
            'report.performance.top-student' => 'reports.view',
            'report.performance.top-class' => 'reports.view',
            'report.grades' => 'grades.view',
            'report.grades.approval' => 'grades.approval.view',
            'report.grades.approval.show' => 'grades.approval.view',
            'report.grades.approval.update' => 'grades.approval.view',
        ];
    }

    public static function for(Request $request): ?string
    {
        $name = $request->route()?->getName();
        if (! $name) return null;

        return self::forRoute($name, $request->getMethod());
    }

    public static function forRoute(string $name, string $method = 'GET'): ?string
    {

        if ($permission = self::routeMap()[$name] ?? null) return $permission;

        $modules = [
            'configuration.curriculum.grade-level' => 'grade_levels',
            'configuration.curriculum.academic-year' => 'academic_years',
            'configuration.curriculum.subject-category' => 'subject_categories',
            'configuration.curriculum.subject-map' => 'curriculum_subjects',
            'configuration.curriculum.subjects' => 'subjects',
            'configuration.curriculum.batch' => 'batches',
            'configuration.curriculum.class' => 'classes',
            'configuration.curriculum' => 'curricula',
            'configuration.accounts.students' => 'student_accounts',
            'configuration.accounts.guardians' => 'guardians',
            'configuration.accounts.teachers' => 'faculty',
            'academic.schedule-load.class-schedule' => 'class_schedules',
            'academic.schedule-load.teacher-load' => 'teacher_loads',
            'academic.schedule-load.rooms' => 'rooms',
        ];

        foreach ($modules as $prefix => $module) {
            if ($name === $prefix || str_starts_with($name, $prefix.'.')) {
                return $module.'.'.self::action($method, $name);
            }
        }

        return null;
    }

    private static function action(string $method, string $name): string
    {
        if (str_ends_with($name, '.destroy')) return 'delete';
        if (str_ends_with($name, '.update')) return 'update';
        if (str_ends_with($name, '.store')) return 'create';
        if (str_ends_with($name, '.reset-password')) return 'reset_password';
        return strtoupper($method) === 'GET' ? 'view' : 'update';
    }
}
