<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curriculum_subjects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('curriculum_id')->nullable();
            $table->integer('subject_id');
            $table->unsignedTinyInteger('grade_level');
            $table->unsignedTinyInteger('semester');
            $table->decimal('units', 4, 1)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(1);
            $table->string('prerequisites')->nullable();
            $table->timestamps();

            $table->index('curriculum_id');
            $table->index('subject_id');
            $table->index(['curriculum_id', 'grade_level', 'semester', 'sort_order'], 'curriculum_subject_lookup_index');
            $table->unique(['curriculum_id', 'subject_id', 'grade_level', 'semester'], 'curriculum_subject_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_subjects');
    }
};
