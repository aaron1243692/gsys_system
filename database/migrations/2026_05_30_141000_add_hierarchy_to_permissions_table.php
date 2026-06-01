<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('permissions', 'codename')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->string('codename')->nullable()->after('name');
            });

            DB::table('permissions')
                ->whereNull('codename')
                ->update(['codename' => DB::raw('name')]);

            Schema::table('permissions', function (Blueprint $table) {
                $table->unique('codename');
            });
        }

        if (! Schema::hasColumn('permissions', 'parent_id')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->foreignId('parent_id')
                    ->nullable()
                    ->after('codename')
                    ->constrained('permissions')
                    ->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('permissions', 'parent_id')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->dropConstrainedForeignId('parent_id');
            });
        }

        if (Schema::hasColumn('permissions', 'codename')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->dropUnique(['codename']);
                $table->dropColumn('codename');
            });
        }
    }
};
