<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\CurriculumSubject;
use App\Models\GradeLevel;
use App\Models\Subject;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CurriculumSubjectController extends Controller
{
    public function index(Request $request): View
    {
        $curriculumId = (int) $request->query('curriculum_id');
        $selectedCurriculum = Curriculum::query()
            ->when($curriculumId > 0, fn ($query) => $query->where('id', $curriculumId))
            ->orderBy('id')
            ->first();

        $curriculums = Curriculum::query()
            ->with('track')
            ->orderBy('name')
            ->get();

        $curriculumSubjects = $selectedCurriculum
            ? CurriculumSubject::query()
                ->with('subject.teacher')
                ->where('curriculum_id', $selectedCurriculum->id)
                ->orderBy('grade_level')
                ->orderBy('semester')
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get()
                ->groupBy(fn (CurriculumSubject $row) => "{$row->grade_level}-{$row->semester}")
            : collect();

        $gradeLevels = GradeLevel::query()
            ->orderBy('name')
            ->get()
            ->map(fn (GradeLevel $gradeLevel) => [
                'value' => $this->gradeLevelNumber($gradeLevel->name),
                'name' => 'Grade '.$this->gradeLevelNumber($gradeLevel->name),
            ])
            ->filter(fn (array $gradeLevel) => in_array($gradeLevel['value'], [11, 12], true))
            ->unique('value')
            ->values();

        if ($gradeLevels->isEmpty()) {
            $gradeLevels = collect([
                ['value' => 11, 'name' => 'Grade 11'],
                ['value' => 12, 'name' => 'Grade 12'],
            ]);
        }

        return view('configuration.curiculum.curriculum-subjects', [
            'curriculums' => $curriculums,
            'selectedCurriculum' => $selectedCurriculum,
            'subjects' => Subject::query()->with(['category', 'teacher'])->orderBy('name')->get(),
            'curriculumSubjects' => $curriculumSubjects,
            'gradeLevels' => $gradeLevels,
            'semesters' => [1, 2],
        ]);
    }

    public function store(Request $request, Curriculum $curriculum): RedirectResponse
    {
        $validated = $request->validate([
            'grade_level' => ['required', 'integer', 'in:11,12'],
            'semester' => ['required', 'integer', 'in:1,2'],
            'subject_ids' => ['nullable', 'array'],
            'subject_ids.*' => ['integer', 'distinct', 'exists:subject,id'],
        ]);

        $subjectIds = collect($validated['subject_ids'] ?? [])
            ->map(fn ($subjectId) => (int) $subjectId)
            ->unique()
            ->values();

        DB::transaction(function () use ($curriculum, $validated, $subjectIds): void {
            CurriculumSubject::query()
                ->where('curriculum_id', $curriculum->id)
                ->where('grade_level', $validated['grade_level'])
                ->where('semester', $validated['semester'])
                ->delete();

            $subjectIds->each(fn (int $subjectId, int $index) => CurriculumSubject::create([
                'curriculum_id' => $curriculum->id,
                'subject_id' => $subjectId,
                'grade_level' => $validated['grade_level'],
                'semester' => $validated['semester'],
                'sort_order' => $index + 1,
            ]));
        });

        return redirect()
            ->route('configuration.curriculum.subject-map', ['curriculum_id' => $curriculum->id])
            ->with('success', 'Curriculum subjects saved successfully.');
    }

    public function load(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'curriculum_id' => ['required', 'integer', 'exists:curriculum,id'],
            'grade_level' => ['required', 'integer', 'in:11,12'],
            'semester' => ['required', 'integer', 'in:1,2'],
        ]);

        $subjects = CurriculumSubject::query()
            ->with('subject.teacher')
            ->where('curriculum_id', $validated['curriculum_id'])
            ->where('grade_level', $validated['grade_level'])
            ->where('semester', $validated['semester'])
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->map(fn (CurriculumSubject $curriculumSubject) => [
                'id' => $curriculumSubject->subject?->id,
                'code' => $curriculumSubject->subject?->code,
                'name' => $curriculumSubject->subject?->name,
                'teacher' => $curriculumSubject->subject?->teacher?->name,
            ])
            ->filter(fn (array $subject) => $subject['id'] !== null)
            ->values();

        return response()->json([
            'subjects' => $subjects,
        ]);
    }

    private function gradeLevelNumber(string $name): ?int
    {
        preg_match('/\d+/', $name, $matches);

        return isset($matches[0]) ? (int) $matches[0] : null;
    }
}
