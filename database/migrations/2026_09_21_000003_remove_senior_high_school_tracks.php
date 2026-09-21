<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    public function up(): void
    {
        $this->removeTrackPermissions();

        foreach (['batch', 'class', 'curriculum'] as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'track_id')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('track_id');
                });
            }
        }

        Schema::dropIfExists('tracksub');
        Schema::dropIfExists('track');
    }

    public function down(): void
    {
        throw new RuntimeException('The removed Track module and its data cannot be restored automatically.');
    }

    private function removeTrackPermissions(): void
    {
        if (! Schema::hasTable('permissions')) {
            return;
        }

        DB::transaction(function () {
            $permissionIds = DB::table('permissions')
                ->whereIn('codename', ['group.tracks', 'group.track_subjects'])
                ->orWhere('codename', 'like', 'tracks.%')
                ->orWhere('codename', 'like', 'track_subjects.%')
                ->pluck('id');

            if ($permissionIds->isEmpty()) {
                return;
            }

            foreach (['role_has_permissions', 'model_has_permissions'] as $pivotTable) {
                if (Schema::hasTable($pivotTable)) {
                    DB::table($pivotTable)->whereIn('permission_id', $permissionIds)->delete();
                }
            }

            DB::table('permissions')->whereIn('parent_id', $permissionIds)->delete();
            DB::table('permissions')->whereIn('id', $permissionIds)->delete();
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
