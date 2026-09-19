<?php

namespace Tests\Feature;

use App\Models\{Grade, GradeSheet, Guardian, GuardianChild, SchoolClass, Student, StudentAccount, StudentInfo, Subject, Teacher, User};
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{Auth, DB, Hash, Schema};
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class QuarterGradingTest extends TestCase
{
    private Teacher $teacher;
    private Student $student;
    private StudentAccount $studentAccount;
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
                if ($name === 'guardians') { $t->string('contact')->nullable(); $t->string('address')->nullable(); }
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
            $t->increments('id'); $t->string('name'); $t->integer('acady_id'); $t->integer('grlvl_id'); $t->integer('adviser_id')->nullable(); $t->timestamps();
        });
        Schema::create('subject', function (Blueprint $t) {
            $t->increments('id'); $t->string('name'); $t->integer('teacher_id'); $t->softDeletes(); $t->timestamps();
        });
        Schema::create('classsub', function (Blueprint $t) {
            $t->increments('id'); $t->integer('class_id'); $t->integer('sub_id'); $t->integer('teacher_id')->nullable(); $t->timestamps();
        });
        Schema::create('rooms', function (Blueprint $t) { $t->increments('id'); $t->string('name'); $t->timestamps(); });
        Schema::create('classsched', function (Blueprint $t) {
            $t->increments('id'); $t->integer('class_id'); $t->integer('subject_id');
            $t->string('day'); $t->integer('room_id'); $t->string('time_from'); $t->string('time_to'); $t->timestamps();
        });
        Schema::create('stinfo', function (Blueprint $t) {
            $t->increments('id'); $t->unsignedBigInteger('student_id'); $t->string('name');
            $t->date('birthdate')->nullable(); $t->string('gender')->nullable();
            $t->string('contact')->nullable(); $t->string('address')->nullable();
            $t->integer('class_id')->nullable(); $t->integer('acady_id')->nullable(); $t->integer('grlvl_id')->nullable();
            $t->boolean('admited')->default(false); $t->timestamps();
        });
        (require database_path('migrations/2026_09_18_000002_create_student_accounts.php'))->up();
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
        Schema::create('mobile_api_tokens', function (Blueprint $t) {
            $t->id(); $t->string('account_type'); $t->unsignedBigInteger('account_id');
            $t->char('token_hash', 64)->unique(); $t->dateTime('last_used_at')->nullable();
            $t->dateTime('expires_at')->nullable(); $t->timestamps();
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
        DB::table('classsub')->insert(['class_id' => $this->schoolClass->id, 'sub_id' => $this->subject->id, 'teacher_id' => $this->teacher->id]);
        $this->enroll($this->student, 'Student One');
        $this->studentAccount = StudentAccount::create(['student_id' => $this->student->id, 'username' => 'student',
            'email' => 'student@example.test', 'password' => 'test-password', 'name' => 'Student One']);
        $this->studentAccount->forceFill(['status' => 'ACTIVE'])->save();
    }

    private function enroll(Student $student, string $name): void
    {
        StudentInfo::create(['student_id' => $student->id, 'name' => $name, 'class_id' => $this->schoolClass->id,
            'acady_id' => 1, 'grlvl_id' => 1, 'admited' => 1]);
    }

    private function url(): string
    {
        return $this->loadUrl($this->schoolClass, $this->subject);
    }

    private function loadUrl(SchoolClass $class, Subject $subject): string
    {
        $load = \App\Models\ClassSubject::where('class_id', $class->id)->where('sub_id', $subject->id)->firstOrFail();

        return route('teacher.grades', $load);
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
        $this->get('/teacher/subjects/'.$this->schoolClass->id.'/'.$this->subject->id.'/grades')
            ->assertRedirect($this->url());
        foreach ([1, 2, 3] as $q) {
            $this->save($q)->assertRedirect()->assertSessionHasNoErrors();
            $this->assertDatabaseHas('grades', ['student_id' => $this->student->id, 'quarter' => $q, 'grade' => 85.25,
                'created_by' => $this->teacher->id, 'updated_by' => $this->teacher->id]);
        }
        $this->assertDatabaseCount('grades', 3);
    }

    public function test_open_period_allows_partial_draft_persistence_then_complete_submission(): void
    {
        foreach (['Bonifacio', 'Mabini'] as $name) {
            $class = SchoolClass::create(['name' => $name, 'acady_id' => 1, 'grlvl_id' => 1]);
            DB::table('classsub')->insert(['class_id' => $class->id, 'sub_id' => $this->subject->id, 'teacher_id' => $this->teacher->id]);
        }
        $second = Student::create(['username' => 'second', 'password' => 'test-password'])->refresh();
        $this->enroll($second, 'Student Two');
        $this->actingAs($this->teacher, 'teacher')->get(route('teacher.home'))->assertSee('>3<', false);
        $this->get($this->url())->assertOk()->assertSee('Editing</dt><dd>ALLOWED', false)
            ->assertSee('Student One')->assertSee('Student Two');
        $draft = $this->payload();
        $this->post($this->url(), $draft)->assertRedirect()->assertSessionHasNoErrors();
        $this->assertDatabaseHas('grade_sheets', ['teacher_id' => $this->teacher->id, 'status' => 'DRAFT']);
        $this->get($this->url())->assertOk()->assertSee('value="85.25"', false)->assertSee('Editing</dt><dd>ALLOWED', false);
        $draft['action'] = 'submit';
        $this->post($this->url(), $draft)->assertStatus(422);
        $draft['rows'][] = ['student_id' => $second->id, 'grade' => 89, 'remarks' => 'Recorded'];
        $this->post($this->url(), $draft)->assertRedirect()->assertSessionHasNoErrors();
        $this->assertDatabaseHas('grade_sheets', ['teacher_id' => $this->teacher->id, 'status' => 'SUBMITTED']);
        $this->get($this->url())->assertOk()->assertSee('Editing</dt><dd>LOCKED', false)
            ->assertSee('already been submitted');
        $this->post($this->url(), $draft)->assertForbidden();
    }

    public function test_legacy_grade_form_post_saves_and_submits_without_method_error_and_staff_can_review(): void
    {
        $legacyUrl = '/teacher/subjects/'.$this->schoolClass->id.'/'.$this->subject->id.'/grades';
        $draft = $this->payload(1, 91);
        $this->actingAs($this->teacher, 'teacher')->post($legacyUrl, $draft)
            ->assertRedirect($this->url().'?quarter=1')->assertSessionHasNoErrors();
        $this->assertDatabaseHas('grades', ['student_id' => $this->student->id, 'grade' => 91]);
        $this->get($this->url())->assertOk()->assertSee('value="91.00"', false);

        $draft['action'] = 'submit';
        $this->post($legacyUrl, $draft)->assertRedirect($this->url().'?quarter=1')->assertSessionHasNoErrors();
        $sheet = GradeSheet::firstOrFail();
        $this->assertSame('SUBMITTED', $sheet->status);
        $this->assertSame($this->teacher->id, (int) $sheet->submitted_by);
        $this->assertNotNull($sheet->submitted_at);

        $admin = User::create(['username' => 'approver', 'email' => 'approver@example.test', 'password' => 'test-password'])->refresh();
        $admin->assignRole(Role::create(['name' => 'admin', 'guard_name' => 'web']));
        $this->forgetIdentities();
        $this->actingAs($admin, 'web')->get(route('report.grades.approval', ['status' => 'SUBMITTED']))
            ->assertOk()->assertSee('Mathematics')->assertSee('Rizal')->assertSee('SUBMITTED');
        $this->get(route('report.grades.approval.show', $sheet))->assertOk()->assertSee('Student One')->assertSee('91.00');
    }

    public function test_complete_academic_workflow_uses_the_same_records_for_every_portal(): void
    {
        $maria = Student::create(['username' => 'maria-academic', 'password' => 'test-password'])->refresh();
        $pedro = Student::create(['username' => 'pedro-academic', 'password' => 'test-password'])->refresh();
        $this->enroll($maria, 'Maria');
        $this->enroll($pedro, 'Pedro');
        $mariaAccount = StudentAccount::create(['student_id' => $maria->id, 'username' => 'maria-portal',
            'password' => 'test-password', 'name' => 'Maria']);
        $mariaAccount->forceFill(['status' => 'ACTIVE'])->save();

        $guardian = Guardian::create(['username' => 'juan-parent', 'name' => 'Juan Parent', 'password' => 'test-password'])->refresh();
        $link = GuardianChild::create(['guardian_id' => $guardian->id, 'student_id' => $this->student->id]);
        $link->forceFill(['status' => 'VERIFIED'])->save();

        $admin = User::create(['username' => 'workflow-admin', 'email' => 'workflow@example.test', 'password' => 'test-password'])->refresh();
        $admin->assignRole(Role::create(['name' => 'admin', 'guard_name' => 'web']));

        $this->actingAs($this->teacher, 'teacher')->get(route('teacher.subjects'))
            ->assertOk()->assertSee('Mathematics')->assertSee('Rizal');
        $load = \App\Models\ClassSubject::where('class_id', $this->schoolClass->id)->where('sub_id', $this->subject->id)->firstOrFail();
        $this->get(route('teacher.subjects.students', $load))->assertOk()
            ->assertSee('Student One')->assertSee('Maria')->assertSee('Pedro');

        $payload = ['quarter' => 1, 'academic_year_id' => 1, 'complete' => 1, 'action' => 'draft', 'rows' => [
            ['student_id' => $this->student->id, 'grade' => 90],
            ['student_id' => $maria->id, 'grade' => 91],
            ['student_id' => $pedro->id, 'grade' => 89],
        ]];
        $this->post(route('teacher.grades.store', $load), $payload)->assertRedirect();
        $this->get(route('teacher.grades', [$load, 'quarter' => 1]))->assertOk()
            ->assertSee('value="90.00"', false)->assertSee('value="91.00"', false)->assertSee('value="89.00"', false);
        $payload['action'] = 'submit';
        $this->post(route('teacher.grades.store', $load), $payload)->assertRedirect();
        $sheet = GradeSheet::where('teacher_id', $this->teacher->id)->where('quarter', 1)->firstOrFail();
        $this->assertSame('SUBMITTED', $sheet->status);

        $this->forgetIdentities();
        $this->actingAs($admin, 'web')->get(route('report.grades.approval', ['status' => 'SUBMITTED']))
            ->assertOk()->assertSee('Mathematics')->assertSee('Rizal');
        $this->post(route('report.grades.approval.update', $sheet), ['action' => 'approve'])->assertRedirect();
        $this->assertSame('APPROVED', $sheet->refresh()->status);

        $this->forgetIdentities();
        $this->actingAs($this->studentAccount, 'student')->get(route('student.grades'))
            ->assertOk()->assertSee('Mathematics')->assertSee('>90<', false);
        $this->forgetIdentities();
        $this->actingAs($guardian, 'guardian')->get(route('guardian.grades', $this->student))
            ->assertOk()->assertSee('Mathematics')->assertSee('>90<', false);

        $this->forgetIdentities();
        $this->actingAs($mariaAccount, 'student')->get(route('student.grades'))
            ->assertOk()->assertSee('>91<', false)->assertDontSee('>90<', false);
    }

    public function test_returned_sheet_keeps_grades_and_can_be_resubmitted_then_approved(): void
    {
        $admin = User::create(['username' => 'return-admin', 'email' => 'return@example.test', 'password' => 'test-password'])->refresh();
        $admin->assignRole(Role::create(['name' => 'admin', 'guard_name' => 'web']));
        $payload = $this->payload(1, 88);
        $payload['action'] = 'submit';

        $this->actingAs($this->teacher, 'teacher')->post($this->url(), $payload)->assertRedirect();
        $sheet = GradeSheet::firstOrFail();
        $this->forgetIdentities();
        $this->actingAs($admin, 'web')->post(route('report.grades.approval.update', $sheet), [
            'action' => 'return', 'reason' => 'Please verify one of the grades.',
            'correction_until' => now()->addDay()->format('Y-m-d H:i:s'),
        ])->assertRedirect()->assertSessionHas('success', 'Grade sheet returned for correction.');

        $this->assertSame('RETURNED', $sheet->refresh()->status);
        $this->assertSame('Please verify one of the grades.', $sheet->return_reason);
        $this->assertDatabaseHas('grades', ['grade_sheet_id' => $sheet->id, 'student_id' => $this->student->id, 'grade' => 88]);
        $this->forgetIdentities();
        $this->actingAs($this->studentAccount, 'student')->get(route('student.grades'))->assertOk()->assertDontSee('>88<', false);
        $this->forgetIdentities();
        $this->actingAs($this->teacher, 'teacher')->get($this->url())->assertOk()
            ->assertSee('RETURNED FOR CORRECTION')->assertSee('Please verify one of the grades.')
            ->assertSee('Resubmit Grade Sheet')->assertSee('value="88.00"', false);
        $this->post($this->url(), $payload)->assertRedirect();

        $this->assertSame('SUBMITTED', $sheet->refresh()->status);
        $this->assertNull($sheet->return_reason);
        $this->assertDatabaseHas('audit_events', ['target_type' => 'grade_sheets', 'target_id' => $sheet->id, 'action' => 'sheet.resubmitted']);
        $this->forgetIdentities();
        $this->actingAs($admin, 'web')->post(route('report.grades.approval.update', $sheet), ['action' => 'approve'])
            ->assertRedirect()->assertSessionHas('success', 'Grade sheet approved successfully.');
        $this->forgetIdentities();
        $this->actingAs($this->studentAccount, 'student')->get(route('student.grades'))->assertOk()->assertSee('>88<', false);
    }

    public function test_legacy_teacher_classes_redirect_is_read_only(): void
    {
        $this->actingAs($this->teacher, 'teacher')->get('/teacher/classes')
            ->assertRedirect(route('teacher.subjects'));
        $this->post('/teacher/classes')->assertStatus(405);
        $this->delete('/teacher/classes')->assertStatus(405);
    }

    public function test_closed_and_upcoming_periods_lock_view_and_post(): void
    {
        $this->save()->assertSessionHasNoErrors();
        foreach ([['opens_at' => now()->subDays(3), 'closes_at' => now()->subDay(), 'reason' => 'period has closed'],
            ['opens_at' => now()->addDay(), 'closes_at' => now()->addDays(3), 'reason' => 'not opened yet']] as $period) {
            DB::table('grade_encoding_schedules')->where('academic_year_id', 1)->where('quarter', 1)
                ->update(['opens_at' => $period['opens_at'], 'closes_at' => $period['closes_at']]);
            $this->actingAs($this->teacher, 'teacher')->get($this->url())->assertOk()
                ->assertSee('Student One')->assertSee('value="85.25"', false)
                ->assertSee('Editing</dt><dd>LOCKED', false)->assertSee($period['reason']);
            $this->post($this->url(), $this->payload(1, 90))->assertForbidden();
            $this->assertDatabaseHas('grades', ['student_id' => $this->student->id, 'grade' => 85.25]);
        }
    }

    public function test_sheet_status_and_year_decisions_match_the_edit_form(): void
    {
        $workflow = app(\App\Services\GradeWorkflow::class);
        $this->assertFalse($workflow->editingDecision(new GradeSheet(['status' => 'SUBMITTED']), 1, 1)['allowed']);
        $this->assertFalse($workflow->editingDecision(new GradeSheet(['status' => 'APPROVED']), 1, 1)['allowed']);
        $this->assertTrue($workflow->editingDecision(new GradeSheet([
            'status' => 'RETURNED', 'correction_until' => now()->addHour(),
        ]), 1, 1)['allowed']);
        $this->assertFalse($workflow->editingDecision(new GradeSheet([
            'status' => 'RETURNED', 'correction_until' => now()->subHour(),
        ]), 1, 1)['allowed']);

        DB::table('acady')->insert(['id' => 2, 'name' => '2026-2027']);
        DB::table('grade_encoding_schedules')->where('academic_year_id', 1)->update(['academic_year_id' => 2]);
        foreach ([1, 2, 3] as $quarter) {
            $this->actingAs($this->teacher, 'teacher')->get($this->url().'?quarter='.$quarter)->assertOk()
                ->assertSee('NOT CONFIGURED')->assertSee('DRAFT')->assertSee('Editing</dt><dd>LOCKED', false)
                ->assertSee('No encoding schedule is configured for this class school year and quarter.')
                ->assertSee('An OPEN schedule for another school year does not apply to this class.');
            $this->post($this->url(), $this->payload($quarter))->assertForbidden();
        }
        $this->assertDatabaseCount('grades', 0);
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

    public function test_two_teachers_see_only_their_class_subject_loads_and_students(): void
    {
        $otherTeacher = Teacher::create(['username' => 'teacher-b', 'name' => 'Teacher B', 'password' => 'test-password'])->refresh();
        $classB = SchoolClass::create(['name' => 'Bonifacio', 'acady_id' => 1, 'grlvl_id' => 1]);
        $classC = SchoolClass::create(['name' => 'Mabini', 'acady_id' => 1, 'grlvl_id' => 1]);
        $classD = SchoolClass::create(['name' => 'Del Pilar', 'acady_id' => 1, 'grlvl_id' => 1]);
        $statistics = Subject::create(['name' => 'Statistics', 'teacher_id' => $otherTeacher->id]);
        $english = Subject::create(['name' => 'English', 'teacher_id' => $this->teacher->id]);
        $science = Subject::create(['name' => 'Science', 'teacher_id' => $this->teacher->id]);
        foreach ([[$classB, $this->subject, $this->teacher], [$classC, $statistics, $this->teacher],
            [$this->schoolClass, $english, $otherTeacher], [$classD, $science, $otherTeacher]] as [$class, $subject, $teacher]) {
            DB::table('classsub')->insert(['class_id' => $class->id, 'sub_id' => $subject->id, 'teacher_id' => $teacher->id]);
        }
        $otherStudent = Student::create(['username' => 'student-b', 'password' => 'test-password'])->refresh();
        StudentInfo::create(['student_id' => $otherStudent->id, 'name' => 'Student Four', 'class_id' => $classB->id,
            'acady_id' => 1, 'grlvl_id' => 1, 'admited' => 1]);

        $this->actingAs($this->teacher, 'teacher')->get(route('teacher.home'))
            ->assertOk()->assertSee('Teaching Loads')->assertSee('>3<', false);
        $this->get(route('teacher.subjects'))->assertOk()->assertSee('Rizal')->assertSee('Bonifacio')
            ->assertSee('Mabini')->assertDontSee('Del Pilar')->assertDontSee('English');
        $this->get(route('teacher.grades.index'))->assertOk()->assertSee('3 loads')
            ->assertSee('Rizal')->assertSee('Bonifacio')->assertSee('Mabini')->assertDontSee('English');
        $this->get($this->loadUrl($this->schoolClass, $this->subject))
            ->assertOk()->assertSee('Student One')->assertDontSee('Student Four');
        $this->get($this->loadUrl($classB, $this->subject))
            ->assertOk()->assertSee('Student Four')->assertDontSee('Student One');
        $this->get($this->loadUrl($this->schoolClass, $english))->assertForbidden();
        $this->post($this->loadUrl($this->schoolClass, $english), $this->payload())->assertForbidden();
        $this->post($this->url(), ['quarter' => 1, 'academic_year_id' => 1, 'complete' => 1,
            'rows' => [['student_id' => $otherStudent->id, 'grade' => 88]]])->assertForbidden();

        $this->actingAs($otherTeacher, 'teacher')->get(route('teacher.home'))
            ->assertOk()->assertSee('Teaching Loads')->assertSee('>2<', false);
        $this->get(route('teacher.subjects'))->assertOk()->assertSee('Rizal')->assertSee('Del Pilar')
            ->assertDontSee('Bonifacio')->assertDontSee('Mabini')->assertDontSee('Mathematics');
        $this->get(route('teacher.grades.index'))->assertOk()->assertSee('2 loads')
            ->assertSee('Rizal')->assertSee('Del Pilar')->assertDontSee('Mathematics');
        $this->get($this->url())->assertForbidden();
        $this->get($this->loadUrl($this->schoolClass, $english))->assertOk();
        $this->assertDatabaseCount('grades', 0);
    }

    public function test_subject_teachers_and_adviser_have_separate_rosters_and_permissions(): void
    {
        $robert = Teacher::create(['username' => 'robert', 'name' => 'Robert', 'password' => 'test-password'])->refresh();
        $maria = Teacher::create(['username' => 'maria', 'name' => 'Maria', 'password' => 'test-password'])->refresh();
        $this->schoolClass->update(['adviser_id' => $maria->id]);
        $english = Subject::create(['name' => 'English', 'teacher_id' => $robert->id]);
        $englishLoad = \App\Models\ClassSubject::create(['class_id' => $this->schoolClass->id, 'sub_id' => $english->id, 'teacher_id' => $robert->id]);
        $mathLoad = \App\Models\ClassSubject::where('class_id', $this->schoolClass->id)->where('sub_id', $this->subject->id)->firstOrFail();
        foreach (['Juan', 'Pedro', 'Anna'] as $name) {
            $student = Student::create(['username' => strtolower($name), 'password' => 'test-password'])->refresh();
            $this->enroll($student, $name);
        }
        $otherClass = SchoolClass::create(['name' => 'Other Section', 'acady_id' => 1, 'grlvl_id' => 1]);
        $otherStudent = Student::create(['username' => 'outside', 'password' => 'test-password'])->refresh();
        StudentInfo::create(['student_id' => $otherStudent->id, 'name' => 'Outside Student', 'class_id' => $otherClass->id,
            'acady_id' => 1, 'grlvl_id' => 1, 'admited' => 1]);
        DB::table('rooms')->insert(['id' => 1, 'name' => 'Room A']);
        DB::table('classsched')->insert(['class_id' => $this->schoolClass->id, 'subject_id' => $this->subject->id,
            'day' => 'Monday', 'room_id' => 1, 'time_from' => '08:00', 'time_to' => '09:00']);

        $this->actingAs($this->teacher, 'teacher')->get(route('teacher.subjects'))
            ->assertOk()->assertSee('My Subjects')->assertSee('Mathematics')->assertSee('Monday')->assertSee('Room A')
            ->assertDontSee('English')->assertDontSee('My Advisory Class');
        $this->get(route('teacher.subjects.students', $mathLoad))->assertOk()->assertSee('Juan')->assertSee('Pedro')
            ->assertSee('Anna')->assertDontSee('Outside Student');
        $this->get(route('teacher.subjects.students', $englishLoad))->assertForbidden();
        $this->get(route('teacher.advisory-class'))->assertForbidden();
        $this->get($this->loadUrl($this->schoolClass, $english))->assertForbidden();

        $this->forgetIdentities();
        $this->actingAs($robert, 'teacher')->get(route('teacher.subjects'))
            ->assertOk()->assertSee('English')->assertDontSee('Mathematics')->assertDontSee('My Advisory Class');
        $this->get(route('teacher.subjects.students', $englishLoad))->assertOk()->assertSee('Juan')->assertSee('Pedro')
            ->assertSee('Anna')->assertDontSee('Outside Student');
        $this->get($this->loadUrl($this->schoolClass, $this->subject))->assertForbidden();

        $this->forgetIdentities();
        $this->actingAs($maria, 'teacher')->get(route('teacher.subjects'))->assertOk()->assertSee('No subjects assigned yet.');
        $this->get(route('teacher.advisory-class'))->assertOk()->assertSee('Juan')->assertSee('Pedro')->assertSee('Anna')
            ->assertDontSee('Outside Student');
        $this->get($this->loadUrl($this->schoolClass, $this->subject))->assertForbidden();
        $this->get($this->loadUrl($this->schoolClass, $english))->assertForbidden();

        $this->forgetIdentities();
        $this->actingAs($this->studentAccount, 'student')->get(route('student.subjects'))
            ->assertOk()->assertSee('Maria')->assertSee('Mathematics')->assertSee('Teacher One')->assertSee('English')
            ->assertSee('Robert')->assertSee('Monday')->assertSee('Room A');

        $guardian = Guardian::create(['username' => 'parent-subjects', 'password' => 'test-password'])->refresh();
        $link = GuardianChild::create(['guardian_id' => $guardian->id, 'student_id' => $this->student->id]);
        $link->forceFill(['status' => 'VERIFIED'])->save();
        $this->forgetIdentities();
        $this->actingAs($guardian, 'guardian')->get(route('guardian.children'))
            ->assertOk()->assertSee('Maria')->assertSee('Mathematics')->assertSee('Teacher One')->assertSee('English')
            ->assertSee('Robert')->assertSee('Monday')->assertSee('Room A');
    }

    public function test_admin_assignment_controls_teacher_access_immediately(): void
    {
        $admin = User::create(['username' => 'load-admin', 'email' => 'load-admin@example.test', 'password' => 'test-password'])->refresh();
        $admin->assignRole(Role::create(['name' => 'admin', 'guard_name' => 'web']));
        $otherClass = SchoolClass::create(['name' => 'New Section', 'acady_id' => 1, 'grlvl_id' => 1]);
        $subject = Subject::create(['name' => 'New Subject', 'teacher_id' => $this->teacher->id]);
        $this->actingAs($this->teacher, 'teacher')->get(route('teacher.grades', 999999))->assertNotFound();
        $this->forgetIdentities();
        $this->actingAs($admin, 'web')->post(route('academic.schedule-load.teacher-load.store'), [
            'teacher_id' => $this->teacher->id, 'class_id' => $otherClass->id, 'sub_id' => $subject->id,
        ])->assertRedirect();
        $assignment = DB::table('classsub')->where('class_id', $otherClass->id)->where('sub_id', $subject->id)->first();
        $url = route('teacher.grades', $assignment->id);
        $this->assertSame($this->teacher->id, (int) $assignment->teacher_id);
        $this->forgetIdentities();
        $this->actingAs($this->teacher, 'teacher')->get($url)->assertOk();
        $this->get(route('teacher.subjects'))->assertOk()->assertSee('New Subject');
        $this->get(route('teacher.grades.index'))->assertOk()->assertSee('New Subject');
        $this->forgetIdentities();
        $this->actingAs($admin, 'web')->delete(route('academic.schedule-load.teacher-load.destroy', $assignment->id))->assertRedirect();
        $this->forgetIdentities();
        $this->actingAs($this->teacher, 'teacher')->get($url)->assertForbidden();
        $this->get(route('teacher.subjects'))->assertOk()->assertDontSee('New Subject');
        $this->get(route('teacher.grades.index'))->assertOk()->assertDontSee('New Subject');
    }

    public function test_teacher_cannot_encode_an_unassigned_class_or_unrelated_student(): void
    {
        $removedLoadId = DB::table('classsub')->value('id');
        DB::table('classsub')->delete();
        $this->post(route('teacher.grades', $removedLoadId), $this->payload())->assertNotFound();
        DB::table('classsub')->insert(['class_id' => $this->schoolClass->id, 'sub_id' => $this->subject->id, 'teacher_id' => $this->teacher->id]);
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
        DB::table('classsub')->where('class_id', $this->schoolClass->id)->where('sub_id', $this->subject->id)->update(['teacher_id' => $next->id]);
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
        $this->actingAs($this->studentAccount, 'student')->get(route('student.grades'))->assertOk()->assertSee('85.25')->assertSee('Q3')->assertDontSee('Q4');
        $this->get(route('student.home', ['student_id' => $other->id]))->assertForbidden();
        $this->post($this->url(), $this->payload())->assertForbidden();
        $this->forgetIdentities();
        $other->info()->create(['name' => 'Other Student']);
        $otherAccount = StudentAccount::create(['student_id' => $other->id, 'username' => 'other', 'password' => 'test-password']);
        $otherAccount->forceFill(['status' => 'ACTIVE'])->save();
        $this->actingAs($otherAccount, 'student')->get(route('student.grades'))->assertOk()->assertDontSee('85.25');
    }

    public function test_guardian_opens_latest_approved_year_and_keeps_historical_subject_without_load(): void
    {
        $this->submitAndApprove(1, '99');
        DB::table('acady')->insert(['id' => 2, 'name' => '2026-2027']);
        $this->student->info()->update(['acady_id' => 2]);
        DB::table('classsub')->where('class_id', $this->schoolClass->id)->delete();
        $guardian = Guardian::create(['username' => 'historical-parent', 'password' => 'test-password'])->refresh();
        $link = GuardianChild::create(['guardian_id' => $guardian->id, 'student_id' => $this->student->id]);
        $link->forceFill(['status' => 'VERIFIED'])->save();

        $this->forgetIdentities();
        $this->actingAs($this->studentAccount, 'student')->get(route('student.grades'))
            ->assertOk()->assertSee('Mathematics')->assertSee('>99<', false);
        $this->forgetIdentities();
        $this->assertDatabaseHas('guardianchilds', ['guardian_id' => $guardian->id, 'student_id' => $this->student->id, 'status' => 'VERIFIED']);
        $this->actingAs($guardian, 'guardian')->get(route('guardian.children'))->assertOk()->assertSee('Student One');
        $this->actingAs($guardian, 'guardian')->get(route('guardian.grades', $this->student))
            ->assertOk()->assertSee('2025-2026')->assertSee('Mathematics')->assertSee('>99<', false);
        $this->get(route('guardian.grades', [$this->student, 'academic_year_id' => 2]))
            ->assertOk()->assertDontSee('>99<', false);
        $other = Student::create(['username' => 'unrelated', 'password' => 'test-password'])->refresh();
        $this->get(route('guardian.grades', $other))->assertForbidden();
    }

    public function test_mobile_api_uses_revocable_tokens_shared_records_and_role_isolation(): void
    {
        $this->submitAndApprove(1, '99');
        $guardian = Guardian::create(['username'=>'mobile-parent','name'=>'Mobile Parent','email'=>'mobile-parent@example.test','password'=>'test-password'])->refresh();
        $link = GuardianChild::create(['guardian_id'=>$guardian->id,'student_id'=>$this->student->id]);
        $link->forceFill(['status'=>'VERIFIED','relationship'=>'Mother'])->save();
        $other = Student::create(['username'=>'mobile-unlinked','password'=>'test-password'])->refresh();

        $studentLogin = $this->postJson('/api/student/login',['username'=>'student','password'=>'test-password'])
            ->assertOk()->assertJsonPath('data.role','student')->assertJsonStructure(['data'=>['token','token_type','user']]);
        $studentToken = $studentLogin->json('data.token');
        $this->withToken($studentToken)->getJson('/api/me')->assertOk()->assertJsonPath('data.role','student');
        $this->withToken($studentToken)->getJson('/api/student/dashboard')->assertOk()->assertJsonPath('data.student.id',$this->student->id);
        $this->withToken($studentToken)->getJson('/api/student/grades')->assertOk()
            ->assertJsonPath('data.classes.0.subjects.0.grades.q1',99);
        $this->withToken($studentToken)->getJson('/api/guardian/children')->assertForbidden();

        $guardianLogin = $this->postJson('/api/guardian/login',['username'=>'mobile-parent','password'=>'test-password'])->assertOk();
        $guardianToken = $guardianLogin->json('data.token');
        $this->withToken($guardianToken)->getJson('/api/guardian/children')->assertOk()
            ->assertJsonPath('data.0.id',$this->student->id)->assertJsonPath('data.0.relationship','Mother');
        $this->withToken($guardianToken)->getJson('/api/guardian/children/'.$this->student->id.'/grades')->assertOk()
            ->assertJsonPath('data.classes.0.subjects.0.grades.q1',99);
        $this->withToken($guardianToken)->getJson('/api/guardian/children/'.$other->id.'/grades')->assertForbidden();
        $this->withToken($guardianToken)->getJson('/api/student/profile')->assertForbidden();
        $this->withHeader('Authorization','')->getJson('/api/student/dashboard')->assertUnauthorized();
        $this->withToken($guardianToken)->putJson('/api/guardian/profile',['name'=>'Updated Parent','email'=>'updated-parent@example.test','contact'=>'123','address'=>'New Address','current_password'=>'test-password'])
            ->assertOk()->assertJsonPath('data.name','Updated Parent');
        $this->withToken($studentToken)->postJson('/api/logout')->assertOk();
        $this->withToken($studentToken)->getJson('/api/me')->assertUnauthorized();

        $this->withHeader('Authorization','')->postJson('/api/guardian/register',['username'=>'new-mobile-parent','email'=>'new-mobile-parent@example.test','password'=>'test-password','password_confirmation'=>'test-password','name'=>'New Parent','terms'=>true,'privacy'=>true])
            ->assertCreated()->assertJsonPath('data.status','PENDING');
        $this->postJson('/api/guardian/login',['username'=>'new-mobile-parent','password'=>'test-password'])->assertForbidden();
        $this->postJson('/api/student/login',[])->assertUnprocessable()->assertJsonPath('success',false)
            ->assertJsonStructure(['errors'=>['username','password']]);
    }

    public function test_duplicate_name_registration_requires_staff_selected_academic_record(): void
    {
        $rizal = Student::create(['username' => 'juan-rizal', 'password' => 'unused-password'])->refresh();
        $mabini = Student::create(['username' => 'juan-mabini', 'password' => 'unused-password'])->refresh();
        $otherClass = SchoolClass::create(['name' => 'Mabini', 'acady_id' => 1, 'grlvl_id' => 1]);
        StudentInfo::create(['student_id' => $rizal->id, 'name' => 'Juan Dela Cruz', 'birthdate' => '2008-02-01',
            'class_id' => $this->schoolClass->id, 'acady_id' => 1, 'grlvl_id' => 1, 'admited' => 1]);
        StudentInfo::create(['student_id' => $mabini->id, 'name' => 'Juan Dela Cruz', 'birthdate' => '2008-02-01',
            'class_id' => $otherClass->id, 'acady_id' => 1, 'grlvl_id' => 1, 'admited' => 1]);
        DB::table('rooms')->insert(['id' => 1, 'name' => 'Room 1']);
        DB::table('classsched')->insert(['class_id' => $this->schoolClass->id, 'subject_id' => $this->subject->id,
            'day' => 'Monday', 'room_id' => 1, 'time_from' => '08:00', 'time_to' => '09:00']);

        $this->post(route('portal.register.store', ['portal' => 'student']), [
            'name' => 'Juan Dela Cruz', 'username' => 'juan-portal', 'email' => 'juan@example.test',
            'password' => 'test-password', 'password_confirmation' => 'test-password',
            'birthdate' => '2008-02-01', 'gender' => 'Male', 'grlvl_id' => 1, 'acady_id' => 1,
            'terms' => 1, 'privacy' => 1,
        ])->assertRedirect();
        $account = StudentAccount::where('username', 'juan-portal')->firstOrFail();
        $this->assertNull($account->student_id);
        $this->assertSame('PENDING', $account->status);
        $this->assertDatabaseCount('students', 3);
        $this->post(route('portal.login.store', ['portal' => 'student']), [
            'username' => 'juan-portal', 'password' => 'test-password',
        ])->assertSessionHasErrors('username');

        $admin = User::create(['username' => 'reviewer', 'email' => 'reviewer@example.test', 'password' => 'test-password'])->refresh();
        $admin->assignRole(Role::create(['name' => 'admin', 'guard_name' => 'web']));
        $this->forgetIdentities();
        $this->actingAs($admin, 'web')->get(route('configuration.accounts.registrations.show', [
            'type' => 'student', 'id' => $account->id, 'record_search' => 'Juan Dela Cruz',
        ]))->assertOk()->assertSee('Rizal')->assertSee('Mabini');
        $this->post(route('configuration.accounts.registrations.update', ['student', $account->id]), [
            'action' => 'activate',
        ])->assertSessionHasErrors('action');
        $this->post(route('configuration.accounts.registrations.students.link', $account), [
            'student_id' => $rizal->id, 'confirm' => 1,
        ])->assertRedirect();
        $this->assertDatabaseHas('student_accounts', ['id' => $account->id, 'student_id' => $rizal->id, 'status' => 'ACTIVE']);
        $secondAccount = StudentAccount::create(['username' => 'duplicate', 'password' => 'test-password', 'name' => 'Juan Dela Cruz']);
        $this->post(route('configuration.accounts.registrations.students.link', $secondAccount), [
            'student_id' => $rizal->id, 'confirm' => 1,
        ])->assertSessionHasErrors('student_id');

        $this->forgetIdentities();
        $this->post(route('portal.login.store', ['portal' => 'student']), [
            'username' => 'juan-portal', 'password' => 'test-password',
        ])->assertRedirect(route('student.home'));
        $this->get(route('student.home'))->assertOk()->assertSee('Rizal')->assertDontSee('Mabini');
        $this->get(route('student.subjects'))->assertOk()->assertSee('Mathematics')
            ->assertSee('Teacher One')->assertSee('Monday')->assertSee('Room 1');
        $this->forgetIdentities();
        $this->actingAs($this->teacher, 'teacher')->get($this->url())->assertOk()->assertSee('Juan Dela Cruz');
        $this->post($this->url(), ['quarter' => 1, 'academic_year_id' => 1, 'complete' => 1, 'action' => 'submit',
            'rows' => [['student_id' => $this->student->id, 'grade' => 75], ['student_id' => $rizal->id, 'grade' => 92]],
        ])->assertRedirect();
        GradeSheet::query()->update(['status' => 'APPROVED', 'approved_at' => now(), 'approved_by' => 1]);
        $this->forgetIdentities();
        $this->actingAs($account->refresh(), 'student')->get(route('student.grades'))
            ->assertOk()->assertSee('>92<', false)->assertDontSee('>75<', false);

        $guardian = Guardian::create(['username' => 'juan-guardian', 'password' => 'test-password'])->refresh();
        $link = GuardianChild::create(['guardian_id' => $guardian->id, 'student_id' => $rizal->id]);
        $link->forceFill(['status' => 'VERIFIED'])->save();
        $otherLink = GuardianChild::create(['guardian_id' => $guardian->id, 'student_id' => $mabini->id]);
        $otherLink->forceFill(['status' => 'VERIFIED'])->save();
        $this->forgetIdentities();
        $this->actingAs($guardian, 'guardian')->get(route('guardian.children'))
            ->assertOk()->assertSee('Juan Dela Cruz')->assertSee('Rizal')->assertSee('Mabini');
        $this->get(route('guardian.grades', $rizal))->assertOk()->assertSee('>92<', false);
        $this->get(route('guardian.grades', $mabini))->assertOk()->assertDontSee('>92<', false);
        $this->assertNull($mabini->portalAccount);
    }

    public function test_admin_student_pages_show_real_link_status_and_filters(): void
    {
        $unlinkedStudent = Student::create(['username' => 'academic-only', 'password' => 'unused-password'])->refresh();
        StudentInfo::create(['student_id' => $unlinkedStudent->id, 'name' => 'Academic Only',
            'class_id' => $this->schoolClass->id, 'acady_id' => 1, 'grlvl_id' => 1, 'admited' => 1]);
        $pending = StudentAccount::create(['username' => 'portal-only', 'name' => 'Portal Only', 'password' => 'test-password']);
        $admin = User::create(['username' => 'link-admin', 'email' => 'link-admin@example.test', 'password' => 'test-password'])->refresh();
        $admin->assignRole(Role::create(['name' => 'admin', 'guard_name' => 'web']));

        $this->actingAs($admin, 'web')->get(route('configuration.accounts.students', ['link' => 'unlinked']))
            ->assertOk()->assertSee('Portal Only')->assertSee('NOT LINKED')->assertDontSee('Student One');
        $this->get(route('configuration.accounts.students', ['link' => 'linked', 'status' => 'ACTIVE']))
            ->assertOk()->assertSee('Student One')->assertSee('LINKED')->assertDontSee('Portal Only');
        $this->get(route('academic.students.index', ['search' => $unlinkedStudent->student_number]))
            ->assertOk()->assertSee('Academic Only')->assertSee('NOT LINKED')->assertSee('Link Portal Account');

        $this->post(route('configuration.accounts.registrations.students.link', $pending), [
            'student_id' => $unlinkedStudent->id, 'confirm' => 1,
        ])->assertRedirect();
        $this->assertDatabaseHas('student_accounts', ['id' => $pending->id, 'student_id' => $unlinkedStudent->id, 'status' => 'ACTIVE']);
        $this->get(route('academic.students.index', ['search' => $unlinkedStudent->student_number]))
            ->assertOk()->assertSee('ACTIVE')->assertSee('View Account');
    }

    public function test_admin_dashboard_uses_real_year_scoped_metrics_and_permissions(): void
    {
        $this->submitAndApprove(1, '99');
        $admin=User::create(['username'=>'dashboard-admin','email'=>'dashboard-admin@example.test','password'=>'test-password'])->refresh();
        $admin->assignRole(Role::create(['name'=>'admin','guard_name'=>'web']));
        $guardian=Guardian::create(['username'=>'dashboard-parent','password'=>'test-password'])->refresh();
        $link=GuardianChild::create(['guardian_id'=>$guardian->id,'student_id'=>$this->student->id]);
        $link->forceFill(['status'=>'VERIFIED','relationship'=>'Father'])->save();

        $this->forgetIdentities();
        $this->actingAs($admin,'web')->get(route('dashboard'))
            ->assertOk()->assertSee('Welcome, dashboard-admin')->assertSee('2025-2026')
            ->assertSee('Grade Workflow')->assertSee('Approved')->assertSee('Grade Encoding')
            ->assertSee('Teacher Load')->assertSee('Guardian Links')->assertSee('Recent Grade Activity')
            ->assertSee('Quick Actions')->assertSee('Grade Approval')->assertSee('Encoding Schedule');
        $this->get(route('dashboard',['school_year_id'=>999999]))->assertSessionHasErrors('school_year_id');
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

    public function test_staff_add_reuses_legacy_link_and_remove_revokes_guardian_access(): void
    {
        $this->submitAndApprove();
        $guardian = Guardian::create(['username' => 'staff-linked-parent', 'password' => 'test-password'])->refresh();
        $admin = User::create(['username' => 'guardian-link-admin', 'email' => 'guardian-link-admin@example.test', 'password' => 'test-password'])->refresh();
        $admin->assignRole(Role::create(['name' => 'admin', 'guard_name' => 'web']));
        $outsider = User::create(['username' => 'guardian-link-outsider', 'email' => 'guardian-link-outsider@example.test', 'password' => 'test-password'])->refresh();
        $url = route('configuration.accounts.guardians.childs.store', $guardian);
        $payload = ['student_id' => $this->student->id, 'relationship' => 'Mother', 'confirm' => 1];

        $this->actingAs($outsider, 'web')->post($url, $payload)->assertForbidden();
        $this->assertDatabaseMissing('guardianchilds', ['guardian_id' => $guardian->id]);
        $this->forgetIdentities();
        $this->actingAs($this->teacher, 'teacher')->post($url, $payload)->assertForbidden();
        $this->forgetIdentities();
        $this->actingAs($this->studentAccount, 'student')->post($url, $payload)->assertForbidden();
        $this->forgetIdentities();
        $this->actingAs($guardian, 'guardian')->post('/guardian/children/link', $payload)->assertStatus(405);

        $this->forgetIdentities();
        $this->actingAs($admin, 'web')->get(route('configuration.accounts.guardians'))
            ->assertOk()->assertSee('Student One')->assertSee('Add Child');
        $this->actingAs($admin, 'web')->post($url, $payload)->assertRedirect();
        $link = GuardianChild::where('guardian_id', $guardian->id)->where('student_id', $this->student->id)->firstOrFail();
        $this->assertSame('VERIFIED', $link->status);
        $this->assertSame('Mother', $link->relationship);
        $this->assertSame($admin->id, $link->verified_by);
        $this->post($url, $payload)->assertSessionHasErrors('student_id');
        $this->assertSame(1, GuardianChild::where('guardian_id', $guardian->id)->count());

        $this->forgetIdentities();
        $this->actingAs($guardian, 'guardian')->get(route('guardian.children'))
            ->assertOk()->assertSee('1 child')->assertSee('Student One')->assertSee('Mother')->assertDontSee('Request Child Link');
        $this->get(route('guardian.grades', $this->student))->assertOk()->assertSee('85.25');
        $other = Student::create(['username' => 'unlinked-academic', 'password' => 'unused-password'])->refresh();
        $this->get(route('guardian.grades', $other))->assertForbidden();

        $legacy = GuardianChild::create(['guardian_id' => $guardian->id, 'student_id' => $other->id]);
        $this->assertSame('PENDING', $legacy->refresh()->status);
        $this->get(route('guardian.children'))->assertDontSee('unlinked-academic');
        $this->get(route('guardian.grades', $other))->assertForbidden();
        $this->forgetIdentities();
        $this->actingAs($outsider, 'web')->post($url, ['student_id'=>$other->id,'relationship'=>'Father','confirm'=>1])->assertForbidden();
        $this->delete(route('configuration.accounts.guardians.childs.destroy', $legacy))->assertForbidden();
        $this->assertSame('PENDING', $legacy->refresh()->status);
        $this->forgetIdentities();
        $this->actingAs($admin, 'web')->post($url, ['student_id'=>$other->id,'confirm'=>1])
            ->assertSessionHasErrors('relationship');
        $this->assertSame('PENDING', $legacy->refresh()->status);
        $this->post($url, ['student_id'=>$other->id,'relationship'=>'Father','confirm'=>1])->assertRedirect();
        $this->assertSame('VERIFIED', $legacy->refresh()->status);
        $this->assertSame('Father', $legacy->relationship);
        $this->assertSame($admin->id, $legacy->verified_by);
        $this->assertSame(2, GuardianChild::where('guardian_id', $guardian->id)->count());
        $secondGuardian = Guardian::create(['username' => 'second-staff-linked-parent', 'password' => 'test-password'])->refresh();
        $this->post(route('configuration.accounts.guardians.childs.store', $secondGuardian), [
            'student_id' => $other->id, 'relationship' => 'Mother', 'confirm' => 1,
        ])->assertRedirect();
        $this->assertDatabaseHas('guardianchilds', ['guardian_id' => $secondGuardian->id,
            'student_id' => $other->id, 'status' => 'VERIFIED']);
        $this->forgetIdentities();
        $this->actingAs($guardian, 'guardian')->get(route('guardian.children'))
            ->assertOk()->assertSee('2 children')->assertSee('Student One')->assertSee('unlinked-academic');
        $this->get(route('guardian.grades', $other))->assertOk();
        $this->forgetIdentities();
        $this->actingAs($admin, 'web')->delete(route('configuration.accounts.guardians.childs.destroy', $link))->assertRedirect();
        $this->assertDatabaseMissing('guardianchilds', ['id' => $link->id]);
        $this->forgetIdentities();
        $this->actingAs($guardian, 'guardian')->get(route('guardian.grades', $this->student))->assertForbidden();
        $this->get(route('guardian.grades', $other))->assertOk();
        $this->forgetIdentities();
        $this->actingAs($secondGuardian, 'guardian')->get(route('guardian.children'))
            ->assertOk()->assertSee('unlinked-academic');
        $this->get(route('guardian.grades', $other))->assertOk();
    }

    public function test_historical_context_survives_profile_class_subject_and_year_changes(): void
    {
        $this->submitAndApprove();
        StudentInfo::query()->update(['class_id' => 90, 'acady_id' => 90, 'grlvl_id' => 90]);
        $this->schoolClass->update(['name' => 'Changed', 'acady_id' => 90]);
        $this->subject->update(['name' => 'Changed subject']);
        DB::table('acady')->where('id', 1)->update(['name' => 'Changed year']);
        $this->forgetIdentities();
        $this->actingAs($this->studentAccount, 'student')->get(route('student.grades'))
            ->assertOk()->assertSee('Rizal')->assertSee('Mathematics')->assertSee('2025-2026')->assertSee('Grade 9');
        $this->assertDatabaseHas('grades', ['academic_year_id' => 1, 'class_name' => 'Rizal']);
    }

    public function test_portal_identity_cannot_access_administration(): void
    {
        foreach (['teacher' => $this->teacher, 'student' => $this->studentAccount] as $guard => $identity) {
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
        foreach (['teacher' => $this->teacher, 'student' => $this->studentAccount, 'guardian' => $parent] as $portal => $user) {
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
