<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Guardian;
use App\Models\GuardianChild;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentInfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class StudentSeeder extends Seeder
{
    /**
     * Seed student accounts, profiles, and guardian links.
     */
    public function run(): void
    {
        if (! Schema::hasTable('students')) {
            return;
        }

        $classes = Schema::hasTable('class')
            ? SchoolClass::query()->with('gradeLevel')->orderBy('id')->get()->values()
            : collect();
        $academicYear = Schema::hasTable('acady')
            ? AcademicYear::query()->where('name', '2025-2026')->first() ?? AcademicYear::query()->orderByDesc('year_from')->first()
            : null;
        $guardians = Schema::hasTable('guardians')
            ? Guardian::query()->orderBy('id')->get()->values()
            : collect();

        foreach ($this->students() as $index => $studentData) {
            $username = 'student'.str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT);
            $class = $classes->isNotEmpty() ? $classes[$index % $classes->count()] : null;

            $studentValues = ['password' => Hash::make('student123')];
            if (Schema::hasColumn('students', 'email')) {
                $studentValues['email'] = $username.'@student.gsys.edu.ph';
            }

            $student = Student::updateOrCreate(['username' => $username], $studentValues);

            if (Schema::hasTable('stinfo')) {
                StudentInfo::updateOrCreate(
                    ['student_id' => $student->id],
                    [
                        'lrn' => 110000000000 + $index,
                        'admited' => $index < 54 ? 1 : 0,
                        'name' => $studentData['name'],
                        'gender' => $studentData['gender'],
                        'birthdate' => $studentData['birthdate'],
                        'grlvl_id' => $class?->grlvl_id,
                        'class_id' => $class?->id,
                        'acady_id' => $academicYear?->id,
                        'contact' => '09'.str_pad((string) (180000000 + $index), 9, '0', STR_PAD_LEFT),
                        'address' => 'Barangay '.(($index % 10) + 1).', Cauayan City, Isabela',
                    ]
                );
            }

            if (Schema::hasTable('guardianchilds') && $guardians->isNotEmpty()) {
                $guardian = $guardians[(int) floor($index / 2) % $guardians->count()];
                GuardianChild::updateOrCreate([
                    'guardian_id' => $guardian->id,
                    'student_id' => $student->id,
                ]);
            }
        }
    }

    private function students(): array
    {
        $firstNames = [
            'Juan', 'Maria', 'Jose', 'Ana', 'Carlo', 'Angelica', 'Miguel', 'Sofia',
            'Gabriel', 'Nicole', 'Daniel', 'Andrea', 'Joshua', 'Katrina', 'Marco',
            'Christine', 'Paolo', 'Jasmine', 'Rafael', 'Bianca',
        ];
        $lastNames = [
            'Dela Cruz', 'Santos', 'Reyes', 'Garcia', 'Mendoza', 'Lopez',
            'Flores', 'Aquino', 'Navarro', 'Ramos', 'Torres', 'Castro',
            'Villanueva', 'Bautista', 'Cruz',
        ];

        $students = [];
        for ($index = 0; $index < 60; $index++) {
            $students[] = [
                'name' => $firstNames[$index % count($firstNames)].' '.$lastNames[$index % count($lastNames)],
                'gender' => $index % 2 === 0 ? 'Male' : 'Female',
                'birthdate' => now()->subYears(16 + ($index % 3))->subDays($index * 13)->toDateString(),
            ];
        }

        return $students;
    }
}
