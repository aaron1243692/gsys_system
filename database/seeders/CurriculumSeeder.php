<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Batch;
use App\Models\ClassSubject;
use App\Models\Curriculum;
use App\Models\GradeLevel;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\SubjectCategory;
use App\Models\Teacher;
use App\Models\Track;
use App\Models\TrackSubject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CurriculumSeeder extends Seeder
{
    /**
     * Seed senior high curriculum records.
     */
    public function run(): void
    {
        $gradeLevels = $this->seedGradeLevels();
        $academicYears = $this->seedAcademicYears();
        $tracks = $this->seedTracks();
        $curriculums = $this->seedCurriculums($tracks);
        $this->seedBatches($curriculums);
        $categories = $this->seedSubjectCategories();
        $subjects = $this->seedSubjects($categories);
        $classes = $this->seedClasses($gradeLevels, $academicYears, $tracks);
        $this->seedClassSubjects($classes, $subjects);
        $this->seedTeacherAssignments($classes, $subjects);
        $this->seedTrackSubjects($tracks, $gradeLevels, $subjects);
        $this->seedCurriculumSubjects($curriculums, $subjects);
    }

    private function seedGradeLevels(): array
    {
        if (! Schema::hasTable('grlvl')) {
            return [];
        }

        $levels = [];
        foreach (['Grade 11', 'Grade 12'] as $name) {
            $levels[$name] = GradeLevel::updateOrCreate(['name' => $name])->id;
        }

        return $levels;
    }

    private function seedAcademicYears(): array
    {
        if (! Schema::hasTable('acady')) {
            return [];
        }

        $years = [];
        foreach ([
            ['name' => '2024-2025', 'year_from' => 2024, 'year_to' => 2025],
            ['name' => '2025-2026', 'year_from' => 2025, 'year_to' => 2026],
            ['name' => '2026-2027', 'year_from' => 2026, 'year_to' => 2027],
        ] as $year) {
            $years[$year['name']] = AcademicYear::updateOrCreate(
                ['name' => $year['name']],
                ['year_from' => $year['year_from'], 'year_to' => $year['year_to']]
            )->id;
        }

        return $years;
    }

    private function seedTracks(): array
    {
        if (! Schema::hasTable('track')) {
            return [];
        }

        $tracks = [];
        foreach (['STEM', 'ABM', 'HUMSS', 'GAS'] as $name) {
            $tracks[$name] = Track::updateOrCreate(['name' => $name])->id;
        }

        return $tracks;
    }

    private function seedCurriculums(array $tracks): array
    {
        if (! Schema::hasTable('curriculum')) {
            return [];
        }

        $curriculums = [];
        foreach (['STEM' => 'Senior High STEM Curriculum', 'ABM' => 'Senior High ABM Curriculum'] as $track => $name) {
            $curriculums[$track] = Curriculum::updateOrCreate(
                ['name' => $name],
                ['track_id' => $tracks[$track] ?? null]
            )->id;
        }

        return $curriculums;
    }

    private function seedBatches(array $curriculums): void
    {
        if (! Schema::hasTable('batch')) {
            return;
        }

        foreach ([2024, 2025, 2026] as $year) {
            Batch::updateOrCreate(
                ['year' => $year],
                ['curriculum_id' => $curriculums['STEM'] ?? null]
            );
        }
    }

    private function seedSubjectCategories(): array
    {
        if (! Schema::hasTable('subcat')) {
            return [];
        }

        $categories = [];
        foreach (['Core Subject', 'Applied Subject', 'Specialized Subject'] as $name) {
            $categories[$name] = SubjectCategory::updateOrCreate(['name' => $name])->id;
        }

        return $categories;
    }

    private function seedSubjects(array $categories): array
    {
        if (! Schema::hasTable('subject')) {
            return [];
        }

        $teachers = Teacher::query()->orderBy('id')->get()->values();
        $subjectData = [
            ['OCOM', 'Oral Communication', 'Core Subject'],
            ['RW', 'Reading and Writing', 'Core Subject'],
            ['GMATH', 'General Mathematics', 'Core Subject'],
            ['STAT', 'Statistics and Probability', 'Core Subject'],
            ['ELS', 'Earth and Life Science', 'Core Subject'],
            ['PSCI', 'Physical Science', 'Core Subject'],
            ['PR1', 'Practical Research 1', 'Applied Subject'],
            ['PR2', 'Practical Research 2', 'Applied Subject'],
            ['ETECH', 'Empowerment Technologies', 'Applied Subject'],
            ['ENTREP', 'Entrepreneurship', 'Applied Subject'],
            ['WI', 'Work Immersion', 'Applied Subject'],
            ['PRECAL', 'Pre-Calculus', 'Specialized Subject'],
            ['BCAL', 'Basic Calculus', 'Specialized Subject'],
            ['BIO1', 'General Biology 1', 'Specialized Subject'],
            ['BIO2', 'General Biology 2', 'Specialized Subject'],
        ];

        $subjects = [];
        foreach ($subjectData as $index => [$code, $name, $category]) {
            $teacher = $teachers->isNotEmpty() ? $teachers[$index % $teachers->count()] : null;
            $subject = Subject::withTrashed()->updateOrCreate(
                ['name' => $name],
                [
                    'code' => $code,
                    'subcat_id' => $categories[$category] ?? null,
                    'teacher_id' => $teacher?->id,
                ]
            );

            if (method_exists($subject, 'trashed') && $subject->trashed()) {
                $subject->restore();
            }

            $subjects[$code] = $subject->id;
        }

        return $subjects;
    }

    private function seedClasses(array $gradeLevels, array $academicYears, array $tracks): array
    {
        if (! Schema::hasTable('class')) {
            return [];
        }

        $teachers = Teacher::query()->orderBy('id')->get()->values();
        $activeYear = $academicYears['2025-2026'] ?? array_values($academicYears)[0] ?? null;
        $classData = [
            ['Grade 11 STEM A', 'Grade 11', 'STEM'],
            ['Grade 11 STEM B', 'Grade 11', 'STEM'],
            ['Grade 11 ABM A', 'Grade 11', 'ABM'],
            ['Grade 12 STEM A', 'Grade 12', 'STEM'],
            ['Grade 12 STEM B', 'Grade 12', 'STEM'],
            ['Grade 12 ABM A', 'Grade 12', 'ABM'],
        ];

        $classes = [];
        foreach ($classData as $index => [$name, $grade, $track]) {
            $existingClass = SchoolClass::query()->where('name', $name)->first();
            $usedAdviserIds = SchoolClass::query()
                ->whereNotNull('adviser_id')
                ->when($existingClass, fn ($query) => $query->where('id', '!=', $existingClass->id))
                ->pluck('adviser_id')
                ->all();
            $teacher = $teachers->first(fn (Teacher $teacher) => ! in_array($teacher->id, $usedAdviserIds, true));

            $classes[$name] = SchoolClass::updateOrCreate(
                ['name' => $name],
                [
                    'grlvl_id' => $gradeLevels[$grade] ?? null,
                    'track_id' => $tracks[$track] ?? null,
                    'acady_id' => $activeYear,
                    'adviser_id' => $teacher?->id,
                ]
            )->id;
        }

        return $classes;
    }

    private function seedClassSubjects(array $classes, array $subjects): void
    {
        if (! Schema::hasTable('classsub')) {
            return;
        }

        foreach ($classes as $classId) {
            foreach (array_slice(array_values($subjects), 0, 10) as $subjectId) {
                ClassSubject::updateOrCreate([
                    'class_id' => $classId,
                    'sub_id' => $subjectId,
                ]);
            }
        }
    }

    private function seedTrackSubjects(array $tracks, array $gradeLevels, array $subjects): void
    {
        if (! Schema::hasTable('tracksub')) {
            return;
        }

        $stemSubjects = ['GMATH', 'STAT', 'ELS', 'PSCI', 'PRECAL', 'BCAL', 'BIO1', 'BIO2'];
        $abmSubjects = ['GMATH', 'STAT', 'ENTREP', 'PR1', 'PR2', 'WI'];

        foreach (['STEM' => $stemSubjects, 'ABM' => $abmSubjects] as $track => $codes) {
            foreach ($codes as $code) {
                if (! isset($tracks[$track], $subjects[$code])) {
                    continue;
                }

                TrackSubject::updateOrCreate([
                    'track_id' => $tracks[$track],
                    'subject_id' => $subjects[$code],
                ], [
                    'grlvl_id' => $gradeLevels['Grade 11'] ?? null,
                ]);
            }
        }
    }

    private function seedTeacherAssignments(array $classes, array $subjects): void
    {
        $teachers = Teacher::query()->orderBy('id')->get()->values();
        if ($teachers->isEmpty()) {
            return;
        }

        if (Schema::hasTable('teacherclass')) {
            foreach (array_values($classes) as $index => $classId) {
                $teacher = $teachers[$index % $teachers->count()];
                DB::table('teacherclass')->updateOrInsert([
                    'teacher_id' => $teacher->id,
                    'class_id' => $classId,
                ], [
                    'updated_at' => now(),
                    'created_at' => now(),
                ]);
            }
        }

        if (Schema::hasTable('teachersub')) {
            foreach (array_values($subjects) as $index => $subjectId) {
                $teacher = $teachers[$index % $teachers->count()];
                DB::table('teachersub')->updateOrInsert([
                    'teacher_id' => $teacher->id,
                    'subject_id' => $subjectId,
                ], [
                    'updated_at' => now(),
                    'created_at' => now(),
                ]);
            }
        }
    }

    private function seedCurriculumSubjects(array $curriculums, array $subjects): void
    {
        if (! Schema::hasTable('curriculum_subjects')) {
            return;
        }

        $semesterSubjects = [
            11 => [
                1 => ['OCOM', 'GMATH', 'ELS', 'PR1', 'PRECAL'],
                2 => ['RW', 'STAT', 'PSCI', 'ETECH', 'BIO1'],
            ],
            12 => [
                1 => ['PR2', 'ENTREP', 'BCAL', 'BIO2'],
                2 => ['WI', 'STAT', 'BIO2'],
            ],
        ];

        foreach ($curriculums as $curriculumId) {
            foreach ($semesterSubjects as $gradeLevel => $semesters) {
                foreach ($semesters as $semester => $codes) {
                    foreach ($codes as $sort => $code) {
                        if (! isset($subjects[$code])) {
                            continue;
                        }

                        $keys = [
                            'curriculum_id' => $curriculumId,
                            'subject_id' => $subjects[$code],
                            'grade_level' => $gradeLevel,
                            'semester' => $semester,
                        ];
                        $values = [
                            'units' => 0,
                            'sort_order' => $sort + 1,
                            'updated_at' => now(),
                        ];

                        if (Schema::hasColumn('curriculum_subjects', 'year_level')) {
                            $values['year_level'] = $gradeLevel;
                        }

                        if (! DB::table('curriculum_subjects')->where($keys)->exists()) {
                            $values['created_at'] = now();
                        }

                        DB::table('curriculum_subjects')->updateOrInsert($keys, $values);
                    }
                }
            }
        }
    }
}
