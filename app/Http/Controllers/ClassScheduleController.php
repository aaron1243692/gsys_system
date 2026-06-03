<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\ClassSchedule;
use App\Models\GradeLevel;
use App\Models\Room;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Track;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClassScheduleController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $classes = SchoolClass::query()
            ->with(['adviser', 'gradeLevel', 'track', 'academicYear', 'classSchedules.subject', 'classSchedules.room'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('adviser', fn ($teacherQuery) => $teacherQuery->where('name', 'like', "%{$search}%"));
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('academic.scheduleload.classschedule', [
            'classes' => $classes,
            'gradeLevels' => GradeLevel::query()->orderBy('name')->get(),
            'academicYears' => AcademicYear::query()->orderBy('year_from')->orderBy('name')->get(),
            'tracks' => Track::query()->orderBy('name')->get(),
            'teachers' => Teacher::query()->orderBy('name')->get(),
            'subjects' => Subject::query()->orderBy('name')->get(),
            'rooms' => Room::query()->orderBy('name')->get(),
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        SchoolClass::create($this->validateClass($request));

        return redirect()
            ->route('academic.schedule-load.class-schedule')
            ->with('success', 'Class added successfully.');
    }

    public function update(Request $request, SchoolClass $schoolClass): RedirectResponse
    {
        $schoolClass->update($this->validateClass($request, $schoolClass));

        return redirect()
            ->route('academic.schedule-load.class-schedule')
            ->with('success', 'Class updated successfully.');
    }

    public function destroy(SchoolClass $schoolClass): RedirectResponse
    {
        $schoolClass->delete();

        return redirect()
            ->route('academic.schedule-load.class-schedule')
            ->with('success', 'Class deleted successfully.');
    }

    public function storeSchedule(Request $request, SchoolClass $schoolClass): RedirectResponse
    {
        $validated = $this->validateSchedule($request);
        $validated['class_id'] = $schoolClass->id;

        ClassSchedule::create($validated);

        return redirect()
            ->route('academic.schedule-load.class-schedule')
            ->with('success', 'Schedule added successfully.')
            ->with('open_modal', 'schedule-class-' . $schoolClass->id);
    }

    public function updateSchedule(Request $request, ClassSchedule $classSchedule): RedirectResponse
    {
        $classSchedule->update($this->validateSchedule($request));

        return redirect()
            ->route('academic.schedule-load.class-schedule')
            ->with('success', 'Schedule updated successfully.')
            ->with('open_modal', 'schedule-class-' . $classSchedule->class_id);
    }

    public function destroySchedule(ClassSchedule $classSchedule): RedirectResponse
    {
        $classId = $classSchedule->class_id;
        $classSchedule->delete();

        return redirect()
            ->route('academic.schedule-load.class-schedule')
            ->with('success', 'Schedule deleted successfully.')
            ->with('open_modal', 'schedule-class-' . $classId);
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

    private function validateSchedule(Request $request): array
    {
        return $request->validate([
            'subject_id' => ['required', 'integer', 'exists:subject,id'],
            'day' => ['required', 'string', 'max:20'],
            'room_id' => ['required', 'integer', 'exists:rooms,id'],
            'time_from' => ['required', 'date_format:H:i'],
            'time_to' => ['required', 'date_format:H:i', 'after:time_from'],
        ], [
            'time_to.after' => 'The end time must be later than the start time.',
        ]);
    }
}
