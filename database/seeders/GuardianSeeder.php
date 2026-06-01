<?php

namespace Database\Seeders;

use App\Models\Guardian;
use Illuminate\Database\Seeder;

class GuardianSeeder extends Seeder
{
    /**
     * Seed default guardian account.
     */
    public function run(): void
    {
        Guardian::updateOrCreate(
            ['username' => 'guardian'],
            [
                'email' => 'guardian@example.com',
                'password' => 'guardian1919',
            ]
        );
    }
}
