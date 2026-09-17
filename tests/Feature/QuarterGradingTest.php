<?php

namespace Tests\Feature;

use App\Models\{Grade, GradeSheet, Guardian, GuardianChild, SchoolClass, Student, StudentInfo, Subject, Teacher, User};
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{Auth, DB, Hash, Schema};
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class QuarterGradingTest extends TestCase
{
    private Teacher $teacher;
    private Student $student;
    private SchoolClass $schoolClass;
    private Subject $subject;

    protected function setUp(): void
    {
        parent::setUp();
        // Never migrate or reset the configured GSYS database.
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:',
            'cache.default' => 'array', 'session.driver' => 'array']);
        DB::purge('sqlite');
        foreach (['teachers', 'students', 'guardians', 'users'] as $name) {
            Schema::create($name, function (Blueprint $t) use ($name) {
                $t->id(); $t->string('username')->unique(); $t->string('name')->nullable();
                $t->string('email')->nullable(); $t->string('password');
                $t->string('status', 20)->default('ACTIVE')->index();
                foreach (['activated', 'rejected', 'deactivated'] as $action) {
                    $t->unsignedBigInteger($action.'_by')->nullable();
                    $t->dateTime($action.'_at')->nullable();
                }
                $t->text('rejection_reason')->nullable();
                if ($name === 'students') { $t->char('student_number', 11)->nullable()->unique(); }
                if ($name === 'users') { $t->rememberToken(); }
                $t->timestamps();
            });
        }
        foreach (['acady', 'grlvl'] as $name) {
            Schema::create($name, function (Blueprint $t) { $t->increments('id'); $t->string('name'); $t->timestamps(); });
        }
        Schema::create('class', function (Blueprint $t) {
            $t->increments('id'); $t->string('name'); $t->integer('acady_id'); $t->integer('grlvl_id'); $t->timestamps();
        });
        Schema::create('subject', function (Blueprint $t) {
            $t->increments('id'); $t->string('name'); $t->integer('teacher_id'); $t->softDeletes(); $t->timestamps();
        });
        Schema::create('classsub', function (Blueprint $t) {
            $t->increments('id'); $t->integer('class_id'); $t->integer('sub_id'); $t->timestamps();
        });
        Schema::create('stinfo', function (Blueprint $t) {
            $t->increments('id'); $t->unsignedBigInteger('student_id'); $t->string('name');
            $t->integer('class_id')->nullable(); $t->integer('acady_id')->nullable(); $t->integer('grlvl_id')->nullable();
            $t->boolean('admited')->default(false); $t->timestamps();
        });
        Schema::create('guardianchilds', function (Blueprint $t) {
            $t->increments('id'); $t->integer('guardian_id'); $t->integer('student_id');
            $t->string('status', 20)->default('PENDING')->index(); $t->string('relationship')->nullable();
            $t->string('claimed_student_name')->nullable(); $t->date('claimed_birthdate')->nullable();
            $t->integer('verified_by')->nullable(); $t->dateTime('verified_at')->nullable(); $t->text('verification_note')->nullable();
            $t->timestamps(); $t->unique(['guardian_id', 'student_id'], 'guardian_student_unique');
        });
        Schema::create('grade_encoding_schedules', function (Blueprint $t) {
            $t->id(); $t->integer('academic_year_id'); $t->unsignedTinyInteger('quarter');
            $t->dateTime('opens_at'); $t->dateTime('closes_at'); $t->integer('created_by'); $t->integer('updated_by'); $t->timestamps();
            $t->unique(['academic_year_id', 'quarter'], 'schedule_year_quarter_unique');
        });
        Schema::create('grade_sheets', function (Blueprint $t) {
            $t->id(); $t->integer('teacher_id'); $t->integer('class_id'); $t->integer('subject_id'); $t->integer('academic_year_id');
            $t->integer('grade_level_id')->nullable(); $t->unsignedTinyInteger('quarter'); $t->string('status', 20)->default('DRAFT')->index();
            foreach (['teacher', 'class', 'subject', 'academic_year', 'grade_level'] as $field) { $t->string($field.'_name')->nullable(); }
            $t->json('roster'); $t->integer('submitted_by')->nullable(); $t->dateTime('submitted_at')->nullable();
            $t->integer('returned_by')->nullable(); $t->dateTime('returned_at')->nullable(); $t->integer('approved_by')->nullable(); $t->dateTime('approved_at')->nullable();
            $t->text('return_reason')->nullable(); $t->dateTime('correction_until')->nullable(); $t->timestamps();
            $t->unique(['teacher_id', 'class_id', 'subject_id', 'academic_year_id', 'quarter'], 'sheet_identity_unique');
        });
        Schema::create('audit_events', function (Blueprint $t) {
            $t->id(); $t->string('actor_type'); $t->integer('actor_id')->nullable(); $t->string('action'); $t->string('target_type'); $t->integer('target_id'); $t->json('details')->nullable(); $t->dateTime('created_at'); $t->index(['target_type', 'target_id']);
        });
        Schema::create('agreement_records', function (Blueprint $t) {
            $t->id(); $t->string('account_type'); $t->integer('account_id'); $t->string('document_type'); $t->string('document_version'); $t->dateTime('accepted_at');
        });
        Schema::create('grades', function (Blueprint $t) {
            $t->increments('id'); $t->integer('class_list_id'); $t->integer('subject_id');
            foreach (['first_quarter', 'second_quarter', 'third_quarter', 'final_grade'] as $c) { $t->decimal($c, 5, 2)->nullable(); }
            $t->string('remarks', 50)->nullable(); $t->timestamps();
        });
        (require database_path('migrations/2026_09_11_000001_extend_grades_for_quarter_recording.php'))->up();
        Schema::table('grades', function (Blueprint $t) { $t->unsignedBigInteger('grade_sheet_id')->nullable(); });
        (require database_path('migrations/2026_05_30_135604_create_permission_tables.php'))->up();

        DB::table('acady')->insert(['id' => 1, 'name' => '2025-2026']);
        DB::table('grlvl')->insert(['id' => 1, 'name' => 'Grade 9']);
        foreach ([1, 2, 3] as $quarter) {
            DB::table('grade_encoding_schedules')->insert(['academic_year_id' => 1, 'quarter' => $quarter, 'opens_at' => now()->subDay(), 'closes_at' => now()->addDay(), 'created_by' => 1, 'updated_by' => 1, 'created_at' => now(), 'updated_at' => now()]);
        }
        $this->teacher = Teacher::create(['username' => 'teacher', 'name' => 'Teacher One', 'password' => 'test-password']);
        $this->student = Student::create(['username' => 'student', 'email' => 'student@example.test', 'password' => 'test-password']);
        $this->teacher->refresh();
        $this->student->refresh();
        $this->schoolClass = SchoolClass::create(['name' => 'Rizal', 'acady_id' => 1, 'grlvl_id' => 1]);
        $this->subject = Subject::create(['name' => 'Mathematics', 'teacher_id' => $this->teacher->id]);
        DB::table('classsub')->insert(['class_id' => $this->schoolClass->id, 'sub_id' => $this->subject->id]);
        $this->enroll($this->student, 'Student One');
    }

    private function enroll(Student $student, string $name): void
    {
        StudentInfo::create(['student_id' => $student->id, 'name' => $name, 'class_id' => $this->schoolClass->id,
            'acady_id' => 1, 'grlvl_id' => 1, 'admited' => 1]);
    }

    private function url(): string
    {
        return route('teacher.grades', [$this->schoolClass, $this->subject]);
    }

    private function payload(int $quarter = 1, mixed $grade = '85.25'): array
    {
        return ['quarter' => $quarter, 'academic_year_id' => 1, 'complete' => 1, 'action' => 'draft',
            'rows' => [['student_id' => $this->student->id, 'grade' => $grade, 'remarks' => 'Recorded']]];
    }

    private function save(int $quarter = 1, mixed $grade = '85.25')
    {
        return $this->actingAs($this->teacher, 'teacher')->post($this->url(), $this->payload($quarter, $grade));
    }

    private function submitAndApprove(int $quarter = 1, mixed $grade = '85.25'): void
    {
        $payload = $this->payload($quarter, $grade);
        $payload['action'] = 'submit';
        $this->actingAs($this->teacher, 'teacher')->post($this->url(), $payload)->assertSessionHasNoErrors();
        GradeSheet::where('quarter', $quarter)->update(['status' => 'APPROVED', 'approved_at' => now(), 'approved_by' => 1]);
    }

    public function test_teacher_can_open_assigned_subject_and_encode_each_of_three_quarters(): void
    {
        $this->actingAs($this->teacher, 'teacher')->get($this->url())->assertOk()->assertSee('Student One');
        foreach ([1, 2, 3] as $q) {
            $this->save($q)->assertRedirect()->assertSessionHasNoErrors();
            $this->assertDatabaseHas('grades', ['student_id' => $this->student->id, 'quarter' => $q, 'grade' => 85.25,
                'created_by' => $this->teacher->id, 'updated_by' => $this->teacher->id]);
        }
        $this->assertDatabaseCount('grades', 3);
    }

    public function test_saving_same_quarter_updates_instead_of_duplicating(): void
    {
        $this->save(); $this->save(1, 91)->assertSessionHasNoErrors();
        $this->assertDatabaseCount('grades', 1);
        $this->assertDatabaseHas('grades', ['quarter' => 1, 'grade' => 91]);
    }

    public function test_database_unique_constraint_rejects_duplicate_quarter(): void
    {
        $this->save();
        $attributes = Grade::first()->getAttributes(); unset($attributes['id']);
        $this->expectException(QueryException::class);
        DB::table('grades')->insert($attributes);
    }

    public function test_teacher_cannot_open_or_save_another_teachers_subject(): void
    {
        $other = Teacher::create(['username' => 'other', 'name' => 'Other', 'password' => 'test-password'])->refresh();
        $this->actingAs($other, 'teacher')->get($this->url())->assertForbidden();
        $this->post($this->url(), $this->payload())->assertForbidden();
        $this->assertDatabaseCount('grades', 0);
    }

    public function test_teacher_cannot_encode_an_unassigned_class_or_unrelated_student(): void
    {
        DB::table('classsub')->delete();
        $this->save()->assertForbidden();
        DB::table('classsub')->insert(['class_id' => $this->schoolClass->id, 'sub_id' => $this->subject->id]);
        StudentInfo::query()->update(['class_id' => 99]);
        $this->save()->assertForbidden();
    }

    public function test_invalid_batch_never_partially_saves_and_names_the_student(): void
    {
        $other = Student::create(['username' => 'second', 'password' => 'test-password'])->refresh();
        $this->enroll($other, 'Student Two');
        $payload = $this->payload();
        $payload['rows'][] = ['student_id' => $other->id, 'grade' => 101];
        $response = $this->actingAs($this->teacher, 'teacher')->post($this->url(), $payload);
        $response->assertSessionHasErrors('rows.1.grade');
        $this->assertStringContainsString('Student Two', session('errors')->first('rows.1.grade'));
        $this->assertDatabaseCount('grades', 0);
    }

    public function test_invalid_grades_and_fourth_quarter_are_rejected(): void
    {
        foreach (['text', -1, 101, '85.123'] as $bad) {
            $this->save(1, $bad)->assertSessionHasErrors('rows.0.grade');
        }
        $this->save(4)->assertSessionHasErrors('quarter');
        $this->assertDatabaseCount('grades', 0);
    }

    public function test_configurable_range_and_editability_are_enforced(): void
    {
        config(['grading.minimum' => 60, 'grading.maximum' => 95, 'grading.editable_quarters' => [1, 2]]);
        $this->save(1, 59)->assertSessionHasErrors('rows.0.grade');
        $this->save(1, 96)->assertSessionHasErrors('rows.0.grade');
        $this->save(3, 90)->assertForbidden();
        $this->save(2, 95)->assertSessionHasNoErrors();
    }

    public function test_zero_is_stored_and_blank_does_not_delete_existing_grade(): void
    {
        $this->save(1, 0)->assertSessionHasNoErrors();
        $this->save(1, '')->assertSessionHasErrors('rows');
        $this->assertDatabaseHas('grades', ['grade' => 0]);
    }

    public function test_duplicate_rows_and_stale_year_are_rejected(): void
    {
        $payload = $this->payload(); $payload['rows'][] = $payload['rows'][0];
        $this->actingAs($this->teacher, 'teacher')->post($this->url(), $payload)->assertSessionHasErrors('rows.0.student_id');
        $payload = $this->payload(); $payload['academic_year_id'] = 9;
        $this->post($this->url(), $payload)->assertForbidden();
    }

    public function test_truncated_bulk_submission_is_not_partially_saved(): void
    {
        $payload = $this->payload(); unset($payload['complete']);
        $this->actingAs($this->teacher, 'teacher')->post($this->url(), $payload)->assertSessionHasErrors('complete');
        $this->assertDatabaseCount('grades', 0);
    }

    public function test_reassigned_teacher_is_reauthorized_and_original_creator_is_preserved(): void
    {
        $this->save();
        $next = Teacher::create(['username' => 'replacement', 'name' => 'Replacement', 'password' => 'test-password'])->refresh();
        $this->subject->update(['teacher_id' => $next->id]);
        $this->save()->assertForbidden();
        $this->actingAs($next, 'teacher')->post($this->url(), $this->payload(1, 90))->assertStatus(409);
        $this->assertDatabaseHas('grades', ['created_by' => $this->teacher->id, 'updated_by' => $this->teacher->id, 'grade' => 85.25]);
    }

    public function test_login_rejects_bad_credentials_and_invalid_portal(): void
    {
        $this->post('/portal/teacher/login', ['username' => 'teacher', 'password' => 'incorrect'])
            ->assertSessionHasErrors('username');
        $this->assertGuest('teacher');
        $this->post('/portal/web/login', ['username' => 'teacher', 'password' => 'test-password'])->assertNotFound();
        $this->get(route('teacher.home'))->assertRedirect(route('portal.login', ['portal' => 'teacher']));
    }

    private function forgetIdentities(): void
    {
        foreach (['web', 'teacher', 'student', 'guardian'] as $guard) { Auth::guard($guard)->logout(); }
        Auth::shouldUse('web');
    }

    public function test_student_sees_only_own_grades_and_cannot_edit(): void
    {
        $this->submitAndApprove(); $this->forgetIdentities();
        $other = Student::create(['username' => 'other', 'password' => 'test-password'])->refresh();
        $this->actingAs($this->student, 'student')->get(route('student.grades'))->assertOk()->assertSee('85.25')->assertSee('Q3')->assertDontSee('Q4');
        $this->get(route('student.home', ['student_id' => $other->id]))->assertForbidden();
        $this->post($this->url(), $this->payload())->assertForbidden();
        $this->forgetIdentities();
        $this->actingAs($other, 'student')->get(route('student.grades'))->assertOk()->assertDontSee('85.25');
    }

    public function test_guardian_can_view_linked_child_but_not_unlinked_or_revoked_child(): void
    {
        $this->submitAndApprove(); $this->forgetIdentities();
        $parent = Guardian::create(['username' => 'parent', 'password' => 'test-password'])->refresh();
        $link = GuardianChild::create(['guardian_id' => $parent->id, 'student_id' => $this->student->id]);
        $link->forceFill(['status' => 'VERIFIED'])->save();
        $other = Student::create(['username' => 'other', 'password' => 'test-password'])->refresh();
        $this->actingAs($parent, 'guardian')->get(route('guardian.children'))->assertOk()->assertSee('Student One');
        $this->get(route('guardian.grades', $this->student))->assertOk()->assertSee('85.25');
        $this->get(route('guardian.grades', $other))->assertForbidden();
        $this->get(route('guardian.grades', [$this->student, 'student_id' => $other->id]))->assertForbidden();
        $link->delete();
        $this->get(route('guardian.grades', $this->student))->assertForbidden();
    }

    public function test_historical_context_survives_profile_class_subject_and_year_changes(): void
    {
        $this->submitAndApprove();
        StudentInfo::query()->update(['class_id' => 90, 'acady_id' => 90, 'grlvl_id' => 90]);
        $this->schoolClass->update(['name' => 'Changed', 'acady_id' => 90]);
        $this->subject->update(['name' => 'Changed subject']);
        DB::table('acady')->where('id', 1)->update(['name' => 'Changed year']);
        $this->forgetIdentities();
        $this->actingAs($this->student, 'student')->get(route('student.grades'))
            ->assertOk()->assertSee('Rizal')->assertSee('Mathematics')->assertSee('2025-2026')->assertSee('Grade 9');
        $this->assertDatabaseHas('grades', ['academic_year_id' => 1, 'class_name' => 'Rizal']);
    }

    public function test_portal_identity_cannot_access_administration(): void
    {
        foreach (['teacher' => $this->teacher, 'student' => $this->student] as $guard => $identity) {
            $this->forgetIdentities();
            $this->actingAs($identity, $guard)->get('/configuration/setting/users')->assertForbidden();
            $this->get('/report/grades')->assertForbidden();
        }
    }

    public function test_admin_report_requires_configured_role_and_is_read_only(): void
    {
        $this->save(); $this->forgetIdentities();
        $user = User::create(['username' => 'admin', 'email' => 'admin@example.test', 'password' => 'test-password'])->refresh();
        $this->actingAs($user, 'web')->get('/report/grades')->assertForbidden();
        $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $user->assignRole($role);
        $this->get('/report/grades?quarter=1&academic_year_id=1')->assertOk()->assertSee('85.25');
        $this->post($this->url(), $this->payload())->assertForbidden();
    }

    public function test_each_portal_has_real_session_login_and_logout(): void
    {
        $parent = Guardian::create(['username' => 'parent', 'email' => 'parent@example.test', 'password' => 'test-password'])->refresh();
        foreach (['teacher' => $this->teacher, 'student' => $this->student, 'guardian' => $parent] as $portal => $user) {
            $this->forgetIdentities();
            $this->get(route('portal.login', ['portal' => $portal]))->assertOk();
            $this->post(route('portal.login.store', ['portal' => $portal]), ['username' => $user->username, 'password' => 'test-password'])
                ->assertRedirect(route($portal.'.home'));
            $this->assertAuthenticatedAs($user, $portal);
            $this->get(route($portal.'.home'))->assertOk();
            Auth::shouldUse('web');
            $this->get('/configuration/setting/users')->assertForbidden();
            $this->get('/report/grades')->assertForbidden();
            $this->post(route('portal.logout', ['portal' => $portal]))->assertRedirect();
            $this->assertGuest($portal);
        }
    }

    public function test_migration_preserves_legacy_grade_data(): void
    {
        // This connection is the isolated SQLite fixture, never the real database.
        Schema::drop('grades');
        Schema::create('grades', function (Blueprint $t) {
            $t->increments('id'); $t->integer('class_list_id'); $t->integer('subject_id');
            $t->decimal('first_quarter', 5, 2)->nullable(); $t->decimal('second_quarter', 5, 2)->nullable();
            $t->decimal('third_quarter', 5, 2)->nullable(); $t->decimal('final_grade', 5, 2)->nullable();
            $t->string('remarks', 50)->nullable(); $t->timestamps();
        });
        DB::table('grades')->insert(['id' => 7, 'class_list_id' => 12, 'subject_id' => 4, 'first_quarter' => 91, 'remarks' => 'Legacy']);
        (require database_path('migrations/2026_09_11_000001_extend_grades_for_quarter_recording.php'))->up();
        $this->assertDatabaseHas('grades', ['id' => 7, 'class_list_id' => 12, 'first_quarter' => 91, 'remarks' => 'Legacy']);
        $this->assertSame(0, Grade::recorded()->count());
    }
}
