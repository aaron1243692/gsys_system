<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('curriculum', function (Blueprint $table) {
            if (! Schema::hasColumn('curriculum', 'track_id')) {
                $table->integer('track_id')->nullable()->after('name');
            }
        });

        Schema::table('batch', function (Blueprint $table) {
            if (! Schema::hasColumn('batch', 'curriculum_id')) {
                $table->integer('curriculum_id')->nullable()->after('year');
            }
        });
    }

    public function down(): void
    {
        Schema::table('batch', function (Blueprint $table) {
            if (Schema::hasColumn('batch', 'curriculum_id')) {
                $table->dropColumn('curriculum_id');
            }
        });

        Schema::table('curriculum', function (Blueprint $table) {
            if (Schema::hasColumn('curriculum', 'track_id')) {
                $table->dropColumn('track_id');
            }
        });
    }
};
