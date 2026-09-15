<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\{DB, Schema};

return new class extends Migration
{
    public function up(): void
    {
        foreach (['users', 'teachers', 'students', 'guardians'] as $name) {
            Schema::table($name, function (Blueprint $t) {
                $t->string('status', 20)->default('ACTIVE')->index();
                foreach (['activated', 'rejected', 'deactivated'] as $action) {
                    $t->unsignedBigInteger($action.'_by')->nullable();
                    $t->dateTime($action.'_at')->nullable();
                }
                $t->text('rejection_reason')->nullable();
            });
        }
        Schema::table('students', fn (Blueprint $t) => $t->char('student_number', 11)->nullable()->unique());
        DB::table('students')->orderBy('id')->each(function ($student) {
            do { $number = (string) random_int(10000000000, 99999999999); }
            while (DB::table('students')->where('student_number', $number)->exists());
            DB::table('students')->where('id', $student->id)->update(['student_number' => $number]);
        });
        Schema::table('students', fn (Blueprint $t) => $t->char('student_number', 11)->nullable(false)->change());
        Schema::table('guardianchilds', function (Blueprint $t) {
            $t->string('status', 20)->default('PENDING')->index();
            $t->string('relationship')->nullable();
            $t->string('claimed_student_name')->nullable();
            $t->date('claimed_birthdate')->nullable();
            $t->unsignedBigInteger('verified_by')->nullable();
            $t->dateTime('verified_at')->nullable();
            $t->text('verification_note')->nullable();
            $t->unique(['guardian_id', 'student_id'], 'guardian_student_unique');
        });
        Schema::create('grade_encoding_schedules', function (Blueprint $t) {
            $t->id(); $t->integer('academic_year_id'); $t->unsignedTinyInteger('quarter');
            $t->dateTime('opens_at'); $t->dateTime('closes_at');
            $t->unsignedBigInteger('created_by'); $t->unsignedBigInteger('updated_by'); $t->timestamps();
            $t->unique(['academic_year_id', 'quarter'], 'schedule_year_quarter_unique');
        });
        Schema::create('grade_sheets', function (Blueprint $t) {
            $t->id(); $t->integer('teacher_id'); $t->integer('class_id');
            $t->integer('subject_id'); $t->integer('academic_year_id');
            $t->integer('grade_level_id')->nullable(); $t->unsignedTinyInteger('quarter');
            $t->string('status', 20)->default('DRAFT')->index();
            foreach (['teacher', 'class', 'subject', 'academic_year', 'grade_level'] as $field) $t->string($field.'_name')->nullable();
            $t->json('roster');
            foreach (['submitted', 'returned', 'approved'] as $action) {
                $t->unsignedBigInteger($action.'_by')->nullable(); $t->dateTime($action.'_at')->nullable();
            }
            $t->text('return_reason')->nullable(); $t->dateTime('correction_until')->nullable();
            $t->timestamps();
            $t->unique(['teacher_id', 'class_id', 'subject_id', 'academic_year_id', 'quarter'], 'sheet_identity_unique');
        });
        Schema::table('grades', fn (Blueprint $t) => $t->foreignId('grade_sheet_id')->nullable()->constrained('grade_sheets')->restrictOnDelete());
        Schema::create('audit_events', function (Blueprint $t) {
            $t->id(); $t->string('actor_type'); $t->unsignedBigInteger('actor_id')->nullable();
            $t->string('action'); $t->string('target_type'); $t->unsignedBigInteger('target_id');
            $t->json('details')->nullable(); $t->dateTime('created_at');
            $t->index(['target_type', 'target_id']);
        });
        Schema::create('agreement_records', function (Blueprint $t) {
            $t->id(); $t->string('account_type'); $t->unsignedBigInteger('account_id');
            $t->string('document_type'); $t->string('document_version'); $t->dateTime('accepted_at');
        });
        // Preserve existing encoded data as drafts with historical context. Never infer approval.
        $groups = DB::table('grades')->whereIn('quarter', [1,2,3])->whereNotNull('student_id')->get()
            ->groupBy(fn ($g) => implode(':', [$g->teacher_id, $g->class_id, $g->subject_id, $g->academic_year_id, $g->quarter]));
        foreach ($groups as $rows) {
            $g = $rows->first();
            if (!$g->teacher_id || !$g->class_id || !$g->academic_year_id) continue;
            $data = [];
            foreach (['teacher_id','class_id','subject_id','academic_year_id','grade_level_id','quarter','teacher_name','class_name','subject_name','academic_year_name','grade_level_name'] as $field) $data[$field] = $g->$field;
            $id = DB::table('grade_sheets')->insertGetId($data + ['roster' => json_encode($rows->pluck('student_id')->unique()->values()), 'status' => 'DRAFT', 'created_at' => now(), 'updated_at' => now()]);
            DB::table('grades')->whereIn('id', $rows->pluck('id'))->update(['grade_sheet_id' => $id]);
        }
    }

    public function down(): void
    {
        throw new RuntimeException('Workflow records must be preserved. Use a reviewed manual rollback.');
    }
};
