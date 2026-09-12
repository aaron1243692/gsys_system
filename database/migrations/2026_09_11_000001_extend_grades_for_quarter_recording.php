<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Keep legacy rows and quarter columns intact. New records do not use class_list.
        Schema::table('grades', function (Blueprint $table) {
            $table->integer('class_list_id')->nullable()->change();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('academic_year_id')->nullable();
            $table->integer('grade_level_id')->nullable();
            $table->integer('teacher_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->unsignedTinyInteger('quarter')->nullable();
            $table->decimal('grade', 5, 2)->nullable();
            foreach (['student_name', 'class_name', 'subject_name', 'academic_year_name', 'grade_level_name', 'teacher_name'] as $column) {
                $table->string($column)->nullable();
            }
            $table->unique(['student_id', 'subject_id', 'class_id', 'academic_year_id', 'quarter'], 'grades_student_subject_class_year_quarter_unique');
            $table->index(['class_id', 'subject_id', 'academic_year_id'], 'grades_class_subject_year_index');
            $table->index(['academic_year_id', 'grade_level_id'], 'grades_year_level_index');
            $table->index('teacher_id');
        });
    }

    public function down(): void
    {
        // Removing these columns would erase recorded grades. Roll back application code only.
        throw new RuntimeException('This data-preserving grading migration requires a reviewed manual rollback.');
    }
};
