<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Seed default student account.
     */
    public function run(): void
    {
        Student::updateOrCreate(
            ['username' => 'student'],
            ['password' => 'student1919']
        );
    }
}
