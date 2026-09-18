<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('classsub', function (Blueprint $table) {
            $table->unsignedBigInteger('teacher_id')->nullable()->index();
        });

        // Legacy teacherclass and teachersub are independent lists. Their join would
        // invent class/subject combinations, so Admin must assign each existing row.
    }

    public function down(): void
    {
        throw new RuntimeException('Teaching assignments must be preserved. Use a reviewed manual rollback.');
    }
};
