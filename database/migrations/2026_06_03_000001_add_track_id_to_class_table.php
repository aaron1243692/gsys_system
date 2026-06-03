<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class', function (Blueprint $table) {
            if (! Schema::hasColumn('class', 'track_id')) {
                $table->integer('track_id')->nullable()->after('grlvl_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('class', function (Blueprint $table) {
            if (Schema::hasColumn('class', 'track_id')) {
                $table->dropColumn('track_id');
            }
        });
    }
};
