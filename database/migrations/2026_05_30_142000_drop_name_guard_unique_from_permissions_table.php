<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if ($this->hasIndex('permissions_name_guard_name_unique')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->dropUnique(['name', 'guard_name']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! $this->hasIndex('permissions_name_guard_name_unique')) {
            Schema::table('permissions', function (Blueprint $table) {
                $table->unique(['name', 'guard_name']);
            });
        }
    }

    private function hasIndex(string $name): bool
    {
        return collect(Schema::getIndexes('permissions'))
            ->contains(fn (array $index) => ($index['name'] ?? null) === $name);
    }
};
