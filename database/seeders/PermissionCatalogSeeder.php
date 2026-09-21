<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionCatalogSeeder extends Seeder
{
    public function run(): void
    {
        // The migration is deliberately idempotent (firstOrCreate + givePermissionTo),
        // making this the targeted, repeatable catalog synchronization entry point.
        (require database_path('migrations/2026_09_21_000001_add_web_authorization_permissions.php'))->up();
    }
}
