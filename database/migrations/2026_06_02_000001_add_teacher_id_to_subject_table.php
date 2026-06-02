<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('subject', 'teacher_id')) {
            DB::statement('ALTER TABLE subject MODIFY teacher_id INT NULL');
        } else {
            Schema::table('subject', function (Blueprint $table) {
                $table->integer('teacher_id')->nullable()->after('subcat_id');
            });
        }

        Schema::table('subject', function (Blueprint $table) {
            $table->index('teacher_id');
        });
    }

    public function down(): void
    {
        Schema::table('subject', function (Blueprint $table) {
            $table->dropIndex(['teacher_id']);
            $table->dropColumn('teacher_id');
        });
    }
};
