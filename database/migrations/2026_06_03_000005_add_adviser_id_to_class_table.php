<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('class', function (Blueprint $table) {
            if (! Schema::hasColumn('class', 'adviser_id')) {
                $table->integer('adviser_id')->nullable()->after('acady_id');
                $table->index('adviser_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('class', function (Blueprint $table) {
            if (Schema::hasColumn('class', 'adviser_id')) {
                $table->dropIndex(['adviser_id']);
                $table->dropColumn('adviser_id');
            }
        });
    }
};
