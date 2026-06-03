<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tracksub', function (Blueprint $table) {
            if (! Schema::hasColumn('tracksub', 'grlvl_id')) {
                $table->integer('grlvl_id')->nullable()->after('track_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tracksub', function (Blueprint $table) {
            if (Schema::hasColumn('tracksub', 'grlvl_id')) {
                $table->dropColumn('grlvl_id');
            }
        });
    }
};
