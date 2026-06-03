<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassSubject;
use App\Models\GradeLevel;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Track;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SchoolClassController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $gradeLevelId = $request->query('grlvl_id');
        $academicYearId = $request->query('acady_id');

        $classes = SchoolClass::query()
            ->with(['gradeLevel', 'track', 'academicYear', 'adviser', 'classSubjects.subject.teacher'])
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->when($gradeLevelId, fn ($query) => $query->where('grlvl_id', $gradeLevelId))
            ->when($academicYearId, fn ($query) => $query->where('acady_id', $academicYearId))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.curiculum.class', [
            'classes' => $classes,
            'gradeLevels' => GradeLevel::query()->orderBy('name')->get(),
            'academicYears' => AcademicYear::query()->orderBy('year_from')->orderBy('name')->get(),
            'tracks' => Track::query()->orderBy('name')->get(),
            'subjects' => Subject::query()->with('teacher')->orderBy('name')->get(),
            'teachers' => Teacher::query()->orderBy('name')->get(),
            'search' => $search,
            'gradeLevelId' => $gradeLevelId,
            'academicYearId' => $academicYearId,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateClass($request);

        SchoolClass::create($validated);

        return redirect()
            ->route('configuration.curriculum.class')
            ->with('success', 'Class added successfully.');
    }

    public function update(Request $request, SchoolClass $schoolClass): RedirectResponse
    {
        try {
            $validated = $this->validateClass($request, $schoolClass);
        } catch (ValidationException $exception) {
            return redirect()
                ->back()
                ->withErrors($exception->validator)
                ->withInput()
                ->with('open_modal', 'edit-class-' . $schoolClass->id);
        }

        $schoolClass->update($validated);

        return redirect()
            ->route('configuration.curriculum.class')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy(SchoolClass $schoolClass): RedirectResponse
    {
        $schoolClass->delete();

        return redirect()
            ->route('configuration.curriculum.class')
            ->with('success', 'Class deleted successfully.');
    }

    public function storeSubject(Request $request, SchoolClass $schoolClass): RedirectResponse
    {
        $validated = $request->validate([
            'sub_id' => [
                'required',
                'integer',
                'exists:subject,id',
                Rule::unique('classsub', 'sub_id')->where('class_id', $schoolClass->id),
            ],
        ], [
            'sub_id.unique' => 'This subject is already assigned to the selected class.',
        ]);

        ClassSubject::create([
            'class_id' => $schoolClass->id,
            'sub_id' => $validated['sub_id'],
        ]);

        return redirect()
            ->route('configuration.curriculum.class')
            ->with('success', 'Subject added to class successfully.')
            ->with('open_modal', 'add-subject-class-' . $schoolClass->id);
    }

    public function destroySubject(ClassSubject $classSubject): RedirectResponse
    {
        $classSubject->delete();

        return redirect()
            ->route('configuration.curriculum.class')
            ->with('success', 'Subject removed from class successfully.');
    }

    private function validateClass(Request $request, ?SchoolClass $schoolClass = null): array
    {
        return $request->validate([
            'grlvl_id' => ['required', 'integer', 'exists:grlvl,id'],
            'track_id' => ['nullable', 'integer', 'exists:track,id'],
            'acady_id' => ['required', 'integer', 'exists:acady,id'],
            'adviser_id' => [
                'nullable',
                'integer',
                'exists:teachers,id',
                Rule::unique('class', 'adviser_id')->ignore($schoolClass?->id),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('class', 'name')
                    ->where('grlvl_id', $request->input('grlvl_id'))
                    ->where('acady_id', $request->input('acady_id'))
                    ->ignore($schoolClass?->id),
            ],
        ], [
            'name.unique' => 'This class already exists for the selected grade level and academic year.',
            'adviser_id.unique' => 'This teacher is already assigned as adviser to another class.',
        ]);
    }
}
