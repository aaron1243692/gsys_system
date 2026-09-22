<?php

namespace Tests\Feature;

use App\Models\AcademicYear;
use App\Models\ClassSubject;
use App\Models\GradeLevel;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class WebConflictRegressionTest extends TestCase
{
    use DatabaseTransactions;

    public function test_class_detail_url_redirects_to_the_class_page_and_opens_the_record(): void
    {
        [$admin, $schoolClass] = $this->classWithTeachingLoad();

        $this->actingAs($admin)
            ->get(route('configuration.curriculum.class.show', $schoolClass))
            ->assertRedirect(route('configuration.curriculum.class'))
            ->assertSessionHas('open_modal', 'edit-class-'.$schoolClass->id);
    }

    public function test_curriculum_class_year_conflict_returns_form_feedback_instead_of_409(): void
    {
        [$admin, $schoolClass, $otherYear] = $this->classWithTeachingLoad();

        $this->actingAs($admin)
            ->from(route('configuration.curriculum.class'))
            ->put(route('configuration.curriculum.class.update', $schoolClass), [
                'name' => $schoolClass->name,
                'grlvl_id' => $schoolClass->grlvl_id,
                'acady_id' => $otherYear->id,
                'adviser_id' => null,
            ])
            ->assertRedirect(route('configuration.curriculum.class'))
            ->assertSessionHasErrors('acady_id')
            ->assertSessionHas('open_modal', 'edit-class-'.$schoolClass->id);

        $this->assertSame($schoolClass->acady_id, $schoolClass->fresh()->acady_id);
    }

    public function test_class_schedule_year_conflict_returns_form_feedback_instead_of_409(): void
    {
        [$admin, $schoolClass, $otherYear] = $this->classWithTeachingLoad();

        $this->actingAs($admin)
            ->from(route('academic.schedule-load.class-schedule'))
            ->put(route('academic.schedule-load.class-schedule.update', $schoolClass), [
                'name' => $schoolClass->name,
                'grlvl_id' => $schoolClass->grlvl_id,
                'acady_id' => $otherYear->id,
                'adviser_id' => null,
            ])
            ->assertRedirect(route('academic.schedule-load.class-schedule'))
            ->assertSessionHasErrors('acady_id')
            ->assertSessionHas('open_modal', 'edit-class-schedule-'.$schoolClass->id);

        $this->assertSame($schoolClass->acady_id, $schoolClass->fresh()->acady_id);
    }

    public function test_major_admin_get_pages_do_not_return_conflict_or_server_error(): void
    {
        $admin = $this->admin();
        $routes = [
            'dashboard',
            'configuration.curriculum.index',
            'configuration.curriculum.grade-level',
            'configuration.curriculum.academic-year',
            'configuration.curriculum.batch',
            'configuration.curriculum.class',
            'configuration.curriculum.subject-category',
            'configuration.curriculum.subjects',
            'configuration.curriculum.subject-map',
            'configuration.grade-encoding-schedule',
            'academic.schedule-load.class-schedule',
            'academic.schedule-load.teacher-load',
            'academic.schedule-load.rooms',
            'academic.students.index',
            'academic.students.pre-enlistment',
            'configuration.accounts.registrations',
            'configuration.accounts.students',
            'configuration.accounts.guardians',
            'configuration.accounts.teachers',
            'report.performance.top-student',
            'report.performance.top-class',
            'report.grades',
            'report.grades.approval',
            'configuration.setting.users',
            'configuration.setting.roles',
        ];

        foreach ($routes as $routeName) {
            $response = $this->actingAs($admin)->get(route($routeName));
            $this->assertNotContains($response->getStatusCode(), [409, 500], $routeName);
        }
    }

    private function classWithTeachingLoad(): array
    {
        $gradeLevel = GradeLevel::create(['name' => 'Conflict Test '.str()->random(8)]);
        $currentYear = AcademicYear::create(['name' => 'Conflict Current '.str()->random(8), 'year_from' => 2090, 'year_to' => 2091]);
        $otherYear = AcademicYear::create(['name' => 'Conflict Other '.str()->random(8), 'year_from' => 2091, 'year_to' => 2092]);
        $teacher = Teacher::create([
            'name' => 'Conflict Teacher',
            'username' => 'conflict-teacher-'.str()->random(8),
            'email' => str()->random(8).'@conflict.test',
            'password' => 'password',
        ]);
        $subject = Subject::create(['name' => 'Conflict Subject', 'code' => 'CF-'.str()->random(6)]);
        $schoolClass = SchoolClass::create([
            'name' => 'Conflict Class '.str()->random(8),
            'grlvl_id' => $gradeLevel->id,
            'acady_id' => $currentYear->id,
        ]);
        ClassSubject::create(['class_id' => $schoolClass->id, 'sub_id' => $subject->id, 'teacher_id' => $teacher->id]);

        return [$this->admin(), $schoolClass, $otherYear];
    }

    private function admin(): User
    {
        $role = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $admin = User::factory()->create(['status' => 'ACTIVE']);
        $admin->assignRole($role);

        return $admin;
    }
}
