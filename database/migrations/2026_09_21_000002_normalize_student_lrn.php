<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stinfo', function (Blueprint $table) {
            $table->char('lrn', 12)->nullable()->change();
        });

        if (! collect(Schema::getIndexes('stinfo'))->contains(fn (array $index) => in_array('lrn', $index['columns'] ?? [], true) && ($index['unique'] ?? false))) {
            Schema::table('stinfo', fn (Blueprint $table) => $table->unique('lrn', 'stinfo_lrn_unique'));
        }
    }

    public function down(): void
    {
        // Non-destructive: keep the safer string representation and unique identifier.
    }
};
