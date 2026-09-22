<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\ClassSubject;
use App\Models\GradeEncodingSchedule;
use App\Models\GradeLevel;
use App\Models\Grade;
use App\Models\GradeSheet;
use App\Models\Guardian;
use App\Models\GuardianChild;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SubjectCategory;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecondaryEducationSampleSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $adminId = (int) DB::table('users')->where('username', 'admin')->value('id');
            $years = $this->years();
            $levels = $this->levels();
            $teachers = $this->teachers();
            $subjects = $this->subjects($teachers);
            $classes = $this->classes($levels, $years['2026-2027'], $teachers);

            $this->studentPlacements($classes, $levels, $years['2026-2027']);
            $this->guardians();
            $this->guardianLinks();
            $this->pendingRegistrations($levels, $years['2026-2027']);
            $this->loads($classes, $subjects, $teachers);
            $this->schedules($years['2026-2027'], $adminId);
            $this->gradeWorkflow($classes[0], $years['2026-2027'], $adminId);
            $this->normalizeKnownScratchData($years, $levels);
        });
    }

    private function years(): array
    {
        $result = [];
        foreach ([[2024, 2025], [2025, 2026], [2026, 2027]] as [$from, $to]) {
            $name = "$from-$to";
            $result[$name] = AcademicYear::updateOrCreate(['name' => $name], ['year_from' => $from, 'year_to' => $to]);
        }
        return $result;
    }

    private function levels(): array
    {
        $result = [];
        foreach (range(7, 12) as $number) {
            $name = "Grade $number";
            $result[$number] = GradeLevel::firstOrCreate(['name' => $name]);
        }
        return $result;
    }

    private function teachers(): array
    {
        $profiles = [
            ['teacher', 'Amihan Mercado', 'amihan.mercado@example.com'],
            ['asdsd', 'Benedicto Ramos', 'benedicto.ramos@example.com'],
            ['maria.santos', 'Clarissa Santos', 'clarissa.santos@example.com'],
            ['jose.reyes', 'Danilo Reyes', 'danilo.reyes@example.com'],
            ['ana.cruz', 'Elena Cruz', 'elena.cruz@example.com'],
            ['mark.delacruz', 'Francisco Dela Cruz', 'francisco.delacruz@example.com'],
            ['liza.garcia', 'Gemma Garcia', 'gemma.garcia@example.com'],
            ['ramon.mendoza', 'Hector Mendoza', 'hector.mendoza@example.com'],
            ['patricia.lopez', 'Isabel Lopez', 'isabel.lopez@example.com'],
            ['carlo.aquino', 'Jericho Aquino', 'jericho.aquino@example.com'],
            ['jenny.flores', 'Katrina Flores', 'katrina.flores@example.com'],
            ['edwin.navarro', 'Leandro Navarro', 'leandro.navarro@example.com'],
        ];
        $result = [];
        foreach ($profiles as [$username, $name, $email]) {
            $teacher = Teacher::where('username', $username)->first();
            if ($teacher) {
                $teacher->forceFill(['name' => $name, 'email' => $email, 'status' => 'ACTIVE'])->save();
                $result[] = $teacher;
            }
        }
        return $result;
    }

    private function subjects(array $teachers): array
    {
        $categories = [];
        foreach (['Core Learning Area', 'Applied Learning Area', 'Specialized Learning Area'] as $name) {
            $categories[$name] = SubjectCategory::firstOrCreate(['name' => $name]);
        }
        $data = [
            ['ENG', 'English', 'Core Learning Area'], ['FIL', 'Filipino', 'Core Learning Area'],
            ['MATH', 'Mathematics', 'Core Learning Area'], ['SCI', 'Science', 'Core Learning Area'],
            ['AP', 'Araling Panlipunan', 'Core Learning Area'], ['MAPEH', 'MAPEH', 'Core Learning Area'],
            ['TLE', 'Technology and Livelihood Education', 'Applied Learning Area'], ['ESP', 'Edukasyon sa Pagpapakatao', 'Core Learning Area'],
            ['OCOM', 'Oral Communication', 'Core Learning Area'], ['RW', 'Reading and Writing', 'Core Learning Area'],
            ['GMATH', 'General Mathematics', 'Core Learning Area'], ['STAT', 'Statistics and Probability', 'Core Learning Area'],
            ['ELS', 'Earth and Life Science', 'Core Learning Area'], ['PSCI', 'Physical Science', 'Core Learning Area'],
            ['PR1', 'Practical Research 1', 'Applied Learning Area'], ['PR2', 'Practical Research 2', 'Applied Learning Area'],
            ['ETECH', 'Empowerment Technologies', 'Applied Learning Area'], ['ENTREP', 'Entrepreneurship', 'Applied Learning Area'],
            ['WI', 'Work Immersion', 'Applied Learning Area'], ['PRECAL', 'Pre-Calculus', 'Specialized Learning Area'],
            ['BCAL', 'Basic Calculus', 'Specialized Learning Area'], ['BIO1', 'General Biology 1', 'Specialized Learning Area'],
            ['BIO2', 'General Biology 2', 'Specialized Learning Area'],
        ];
        $result = [];
        foreach ($data as $index => [$code, $name, $category]) {
            $subject = Subject::withTrashed()->updateOrCreate(['code' => $code], [
                'name' => $name,
                'subcat_id' => $categories[$category]->id,
                'teacher_id' => $teachers[$index % count($teachers)]->id,
            ]);
            if ($subject->trashed()) $subject->restore();
            $result[$code] = $subject;
        }
        return $result;
    }

    private function classes(array $levels, AcademicYear $year, array $teachers): array
    {
        $names = [7 => ['Narra', 'Molave'], 8 => ['Sampaguita', 'Ilang-Ilang'], 9 => ['Mabini', 'Bonifacio'], 10 => ['Rizal', 'Luna'], 11 => ['Masikap', 'Matatag'], 12 => ['Mapanuri', 'Malikhain']];
        $result = [];
        $index = 0;
        SchoolClass::where('acady_id', '!=', $year->id)->update(['adviser_id' => null]);
        foreach ($names as $grade => $sections) {
            foreach ($sections as $section) {
                $name = "Grade $grade - $section";
                $class = SchoolClass::updateOrCreate(['name' => $name], [
                    'grlvl_id' => $levels[$grade]->id,
                    'acady_id' => $year->id,
                    'adviser_id' => $teachers[$index]->id,
                ]);
                $result[] = $class;
                $index++;
            }
        }
        return $result;
    }

    private function studentPlacements(array $classes, array $levels, AcademicYear $year): void
    {
        $barangays = ['District I', 'District II', 'District III', 'San Fermin', 'Tagaran', 'Cabugao', 'Alicaocao', 'Minante I', 'Minante II', 'Naganacan'];
        $students = Student::where('username', 'regexp', '^student[0-9]{3}$')->orderBy('username')->limit(60)->get();
        foreach ($students as $index => $student) {
            $grade = 7 + intdiv($index % 60, 10);
            $class = $classes[(($grade - 7) * 2) + ($index % 2)];
            $student->info?->forceFill([
                'lrn' => (string) (910000000001 + $index),
                'admited' => 1,
                'grlvl_id' => $levels[$grade]->id,
                'class_id' => $class->id,
                'acady_id' => $year->id,
                'contact' => '0999000'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                'address' => 'Barangay '.$barangays[$index % count($barangays)].', Cauayan City, Isabela',
            ])->save();
            DB::table('student_accounts')->where('student_id', $student->id)->update([
                'address' => 'Barangay '.$barangays[$index % count($barangays)].', Cauayan City, Isabela',
                'contact' => '0999000'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
            ]);
        }
    }

    private function guardians(): void
    {
        $firstNames = ['Alma','Benito','Corazon','Dante','Estrella','Felipe','Gloria','Honesto','Imelda','Jaime'];
        $barangays = ['District I', 'District II', 'District III', 'San Fermin', 'Tagaran', 'Cabugao', 'Alicaocao', 'Minante I', 'Minante II', 'Naganacan'];
        foreach (Guardian::where('username', 'regexp', '^parent[0-9]{2}$')->orderBy('username')->limit(30)->get() as $index => $guardian) {
            $surname = trim(str_replace('Mr./Ms.', '', $guardian->name));
            $guardian->forceFill([
                'name' => $firstNames[$index % count($firstNames)].' '.$surname,
                'email' => 'guardian'.str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT).'@example.com',
                'contact' => '0999100'.str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                'address' => 'Barangay '.$barangays[$index % count($barangays)].', Cauayan City, Isabela',
                'status' => 'ACTIVE',
            ])->save();
        }
    }

    private function guardianLinks(): void
    {
        $guardians = Guardian::where('username', 'regexp', '^parent[0-9]{2}$')->orderBy('username')->get();
        $students = Student::where('username', 'regexp', '^student[0-9]{3}$')->orderBy('username')->limit(60)->get();
        DB::table('guardianchilds')->whereIn('student_id', $students->pluck('id'))->delete();
        foreach ($students as $index => $student) {
            $guardian = $guardians[intdiv($index, 2) % $guardians->count()];
            DB::table('guardianchilds')->updateOrInsert(
                ['guardian_id' => $guardian->id, 'student_id' => $student->id],
                ['status' => 'VERIFIED', 'relationship' => $index % 2 ? 'Parent' : 'Legal Guardian', 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }

    private function pendingRegistrations(array $levels, AcademicYear $year): void
    {
        $profiles = [
            ['pending.althea', 'Althea Mae Domingo', 'althea.domingo@example.com', '920000000001', 'Female', 'Barangay San Fermin, Cauayan City, Isabela'],
            ['pending.nathaniel', 'Nathaniel Luis Pascual', 'nathaniel.pascual@example.com', '920000000002', 'Male', 'Barangay Tagaran, Cauayan City, Isabela'],
        ];
        $pending = DB::table('stinfo')->where('admited', 0)->orderBy('id')->limit(2)->get();
        foreach ($pending as $index => $info) {
            [$username, $name, $email, $lrn, $gender, $address] = $profiles[$index];
            DB::table('students')->where('id', $info->student_id)->update(['username' => $username, 'email' => $email, 'updated_at' => now()]);
            DB::table('stinfo')->where('id', $info->id)->update([
                'name' => $name, 'lrn' => $lrn, 'gender' => $gender, 'birthdate' => '2011-05-15',
                'grlvl_id' => $levels[7]->id, 'class_id' => null, 'acady_id' => $year->id,
                'contact' => null, 'address' => $address, 'updated_at' => now(),
            ]);
            DB::table('student_accounts')->where('student_id', $info->student_id)->update([
                'username' => $username, 'email' => $email, 'name' => $name,
                'contact' => null, 'address' => $address, 'status' => 'PENDING', 'updated_at' => now(),
            ]);
        }
    }

    private function loads(array $classes, array $subjects, array $teachers): void
    {
        $jhs = ['ENG','FIL','MATH','SCI','AP','MAPEH','TLE','ESP'];
        $shs = ['OCOM','RW','GMATH','STAT','ELS','PR1','ETECH','ENTREP'];
        foreach ($classes as $classIndex => $class) {
            foreach (($classIndex < 8 ? $jhs : $shs) as $subjectIndex => $code) {
                ClassSubject::updateOrCreate(['class_id' => $class->id, 'sub_id' => $subjects[$code]->id], [
                    'teacher_id' => $teachers[($classIndex + $subjectIndex) % count($teachers)]->id,
                ]);
            }
        }
    }

    private function schedules(AcademicYear $year, int $adminId): void
    {
        foreach ([
            1 => [now()->subMonths(3), now()->subMonths(2)],
            2 => [now()->subDays(7), now()->addDays(7)],
            3 => [now()->addMonths(2), now()->addMonths(3)],
        ] as $quarter => [$opens, $closes]) {
            GradeEncodingSchedule::updateOrCreate(['academic_year_id' => $year->id, 'quarter' => $quarter], [
                'opens_at' => $opens, 'closes_at' => $closes, 'created_by' => $adminId, 'updated_by' => $adminId,
            ]);
        }
    }

    private function gradeWorkflow(SchoolClass $class, AcademicYear $year, int $adminId): void
    {
        $load = $class->classSubjects()->whereNotNull('teacher_id')->with(['subject', 'teacher'])->firstOrFail();
        $students = DB::table('stinfo')->where('class_id', $class->id)->where('admited', 1)->orderBy('student_id')->limit(5)->get();
        $sheet = GradeSheet::updateOrCreate([
            'teacher_id' => $load->teacher_id, 'class_id' => $class->id, 'subject_id' => $load->sub_id,
            'academic_year_id' => $year->id, 'quarter' => 1,
        ], [
            'grade_level_id' => $class->grlvl_id, 'status' => 'RETURNED',
            'teacher_name' => $load->teacher->name, 'class_name' => $class->name,
            'subject_name' => $load->subject->name, 'academic_year_name' => $year->name,
            'grade_level_name' => $class->gradeLevel->name, 'roster' => $students->pluck('student_id')->all(),
            'submitted_by' => $load->teacher_id, 'submitted_at' => now()->subDays(2),
            'returned_by' => $adminId, 'returned_at' => now()->subDay(),
            'return_reason' => 'Demo record: verify one encoded grade before resubmission.',
            'correction_until' => now()->addDays(5),
        ]);
        foreach ($students as $index => $studentInfo) {
            Grade::updateOrCreate([
                'student_id' => $studentInfo->student_id, 'subject_id' => $load->sub_id,
                'class_id' => $class->id, 'academic_year_id' => $year->id, 'quarter' => 1,
            ], [
                'grade_sheet_id' => $sheet->id, 'grade_level_id' => $class->grlvl_id,
                'teacher_id' => $load->teacher_id, 'created_by' => $load->teacher_id, 'updated_by' => $load->teacher_id,
                'grade' => 86 + $index, 'student_name' => $studentInfo->name, 'class_name' => $class->name,
                'subject_name' => $load->subject->name, 'academic_year_name' => $year->name,
                'grade_level_name' => $class->gradeLevel->name, 'teacher_name' => $load->teacher->name,
            ]);
        }
    }

    private function normalizeKnownScratchData(array $years, array $levels): void
    {
        DB::table('acady')->where('name', 'asdas')->update(['name' => '2023-2024', 'year_from' => 2023, 'year_to' => 2024]);
        foreach (['asd' => 7, 'sadd' => 8, 'asdas' => 9, 'asdsad' => 10] as $old => $grade) {
            if (! DB::table('class')->where('grlvl_id', DB::table('grlvl')->where('name', $old)->value('id'))->exists()) {
                DB::table('grlvl')->where('name', $old)->delete();
            }
        }
        DB::table('curriculum')->where('name', 'ghgh')->update(['name' => 'Secondary Education Curriculum']);
        DB::table('class')->whereIn('name', ['grade 7a', 'grade 7b'])->update(['grlvl_id' => $levels[9]->id]);
        $historicalClasses = [
            'Grade 8 STEM A' => 'Grade 11 - Maharlika', 'Grade 4 STEM B' => 'Grade 11 - Magiting',
            'Grade 1 ABM A' => 'Grade 11 - Marangal', 'Grade 12 STEM A' => 'Grade 12 - Mapagkalinga',
            'Grade 12 STEM B' => 'Grade 12 - Mapagpasya', 'Grade 12 ABM A' => 'Grade 12 - Mapamaraan',
        ];
        foreach ($historicalClasses as $old => $new) DB::table('class')->where('name', $old)->update(['name' => $new]);
        DB::table('subject')->where('name', 'asdsd')->update(['name' => 'Contemporary Philippine Arts', 'code' => 'CPAR']);
        DB::table('subject')->where('name', 'fdgdfg')->update(['name' => 'Media and Information Literacy', 'code' => 'MIL']);
        DB::table('subject')->where('name', 'g11 math')->update(['name' => 'Chemistry 1', 'code' => 'CHEM1']);
        DB::table('rooms')->where('name', 'lab121')->update(['name' => 'Learning Resource Room']);
        DB::table('subcat')->where('name', 'labolatory')->update(['name' => 'Laboratory']);
        DB::table('subcat')->where('name', 'lecture')->update(['name' => 'Lecture']);
    }
}
