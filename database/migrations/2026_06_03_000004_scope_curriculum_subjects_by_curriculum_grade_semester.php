<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $needsCurriculumId = ! Schema::hasColumn('curriculum_subjects', 'curriculum_id');
        $needsGradeLevel = ! Schema::hasColumn('curriculum_subjects', 'grade_level');

        Schema::table('curriculum_subjects', function (Blueprint $table) {
            if (! Schema::hasColumn('curriculum_subjects', 'curriculum_id')) {
                $table->integer('curriculum_id')->nullable()->after('id');
            }

            if (! Schema::hasColumn('curriculum_subjects', 'grade_level')) {
                $table->unsignedTinyInteger('grade_level')->nullable()->after('subject_id');
            }
        });

        if (Schema::hasColumn('curriculum_subjects', 'year_level')) {
            DB::table('curriculum_subjects')
                ->whereNull('grade_level')
                ->update(['grade_level' => DB::raw('year_level')]);
        }

        $fallbackCurriculumId = DB::table('curriculum')->orderBy('id')->value('id');

        if ($fallbackCurriculumId !== null) {
            DB::table('curriculum_subjects')
                ->whereNull('curriculum_id')
                ->update(['curriculum_id' => $fallbackCurriculumId]);
        }

        if ($needsCurriculumId || $needsGradeLevel) {
            Schema::table('curriculum_subjects', function (Blueprint $table) {
                $table->dropUnique('curriculum_subject_unique');
                $table->index('curriculum_id');
                $table->index(['curriculum_id', 'grade_level', 'semester', 'sort_order'], 'curriculum_subject_lookup_index');
                $table->unique(['curriculum_id', 'subject_id', 'grade_level', 'semester'], 'curriculum_subject_unique');
            });
        }
    }

    public function down(): void
    {
        Schema::table('curriculum_subjects', function (Blueprint $table) {
            $table->dropIndex('curriculum_subject_lookup_index');
            $table->dropIndex(['curriculum_id']);

            if (Schema::hasColumn('curriculum_subjects', 'grade_level')) {
                $table->dropColumn('grade_level');
            }

            if (Schema::hasColumn('curriculum_subjects', 'curriculum_id')) {
                $table->dropColumn('curriculum_id');
            }
        });
    }
};
