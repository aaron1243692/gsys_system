<?php

use App\Models\Permission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        $matrix = [
            'Dashboard' => ['dashboard.view' => 'View'],
            'Grade Levels' => $this->crud('grade_levels'), 'Academic Years' => $this->crud('academic_years'),
            'Subject Categories' => $this->crud('subject_categories'), 'Subjects' => $this->crud('subjects'),
            'Batches' => $this->crud('batches'),
            'Curricula' => $this->crud('curricula'), 'Curriculum Subjects' => $this->crud('curriculum_subjects'),
            'Classes' => $this->crud('classes'), 'Rooms' => $this->crud('rooms'),
            'Class Schedules' => $this->crud('class_schedules'), 'Teacher Loads' => $this->crud('teacher_loads'),
            'Student Accounts' => $this->crud('student_accounts') + ['student_accounts.reset_password' => 'Reset Password'],
            'Guardians' => $this->crud('guardians') + ['guardians.reset_password' => 'Reset Password'],
            'Guardian Children' => ['guardian_children.add' => 'Add', 'guardian_children.remove' => 'Remove'],
            'Faculty' => $this->crud('faculty') + ['faculty.reset_password' => 'Reset Password'],
            'Registrations' => ['registrations.view' => 'View', 'registrations.review' => 'Review', 'registrations.activate' => 'Activate', 'registrations.reject' => 'Reject', 'registrations.deactivate' => 'Deactivate', 'registrations.link_student' => 'Link Student'],
            'Enrollments' => ['enrollments.view' => 'View', 'enrollments.update' => 'Update', 'enrollments.delete' => 'Delete', 'enrollments.admit' => 'Admit'],
            'Users' => $this->crud('users') + ['users.assign_role' => 'Assign Role', 'users.reset_password' => 'Reset Password'],
            'Class Subjects' => ['class_subjects.assign' => 'Assign', 'class_subjects.remove' => 'Remove'],
            'Class Advisers' => ['class_advisers.assign' => 'Assign / Change', 'class_advisers.remove' => 'Remove'],
            'Roles' => $this->crud('roles') + ['permissions.assign' => 'Assign Permissions'],
            'Grade Schedules' => $this->crud('grades.schedule'),
            'Grades' => ['grades.view' => 'View', 'grades.approval.view' => 'View Approval Queue', 'grades.approve' => 'Approve', 'grades.return' => 'Return for Correction'],
            'Reports' => ['reports.view' => 'View'],
        ];

        DB::transaction(function () use ($matrix) {
            foreach ($matrix as $groupName => $items) {
                $group = Permission::query()->firstOrCreate(
                    ['codename' => 'group.'.str($groupName)->snake()],
                    ['name' => $groupName, 'parent_id' => null, 'guard_name' => 'web']
                );
                foreach ($items as $codename => $label) {
                    Permission::query()->firstOrCreate(
                        ['codename' => $codename],
                        ['name' => $label, 'parent_id' => $group->id, 'guard_name' => 'web']
                    );
                }
            }
            if ($admin = Role::query()->where('name', 'admin')->where('guard_name', 'web')->first()) {
                $admin->givePermissionTo(Permission::query()->whereNotNull('parent_id')->get());
            }
        });
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        // Deliberately non-destructive: authorization records may already be assigned.
    }

    private function crud(string $module): array
    {
        return [$module.'.view' => 'View', $module.'.create' => 'Create', $module.'.update' => 'Update', $module.'.delete' => 'Delete'];
    }
};
