<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class TeacherSeeder extends Seeder
{
    /**
     * Seed realistic senior high school teacher accounts.
     */
    public function run(): void
    {
        if (! Schema::hasTable('teachers')) {
            return;
        }

        $teachers = [
            ['name' => 'Maria Santos', 'username' => 'maria.santos', 'email' => 'maria.santos@gsys.edu.ph'],
            ['name' => 'Jose Reyes', 'username' => 'jose.reyes', 'email' => 'jose.reyes@gsys.edu.ph'],
            ['name' => 'Ana Cruz', 'username' => 'ana.cruz', 'email' => 'ana.cruz@gsys.edu.ph'],
            ['name' => 'Mark Dela Cruz', 'username' => 'mark.delacruz', 'email' => 'mark.delacruz@gsys.edu.ph'],
            ['name' => 'Liza Garcia', 'username' => 'liza.garcia', 'email' => 'liza.garcia@gsys.edu.ph'],
            ['name' => 'Ramon Mendoza', 'username' => 'ramon.mendoza', 'email' => 'ramon.mendoza@gsys.edu.ph'],
            ['name' => 'Patricia Lopez', 'username' => 'patricia.lopez', 'email' => 'patricia.lopez@gsys.edu.ph'],
            ['name' => 'Carlo Aquino', 'username' => 'carlo.aquino', 'email' => 'carlo.aquino@gsys.edu.ph'],
            ['name' => 'Jenny Flores', 'username' => 'jenny.flores', 'email' => 'jenny.flores@gsys.edu.ph'],
            ['name' => 'Edwin Navarro', 'username' => 'edwin.navarro', 'email' => 'edwin.navarro@gsys.edu.ph'],
        ];

        foreach ($teachers as $teacher) {
            Teacher::updateOrCreate(
                ['username' => $teacher['username']],
                [
                    'name' => $teacher['name'],
                    'email' => $teacher['email'],
                    'password' => Hash::make('teacher123'),
                ]
            );
        }
    }
}
