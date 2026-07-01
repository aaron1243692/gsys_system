<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Seed default login accounts.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $user = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
            ]
        );

        $user->syncRoles([$role]);
    }
}
