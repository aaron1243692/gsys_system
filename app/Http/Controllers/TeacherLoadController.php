<?php

namespace App\Http\Controllers;

use App\Models\{ClassSubject, SchoolClass, Subject, Teacher};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Gate};
use Illuminate\Validation\ValidationException;

class TeacherLoadController extends Controller
{
    public function index(Request $request)
    {
        Gate::forUser($request->user('web'))->authorize('manage-loads');
        $search = trim((string) $request->query('search'));
        $loads = ClassSubject::with(['teacher', 'subject', 'schoolClass.academicYear', 'schoolClass.gradeLevel', 'schoolClass.classSchedules.room'])
            ->whereNotNull('teacher_id')->whereHas('teacher')->whereHas('subject')->whereHas('schoolClass')
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query->whereHas('teacher', fn ($teacher) => $teacher->where('name', 'like', "%{$search}%"))
                ->orWhereHas('subject', fn ($subject) => $subject->where('name', 'like', "%{$search}%"))
                ->orWhereHas('schoolClass', fn ($class) => $class->where('name', 'like', "%{$search}%"))))
            ->orderBy('class_id')->orderBy('sub_id')->paginate(20)->withQueryString();
        $unassigned = ClassSubject::with(['subject', 'schoolClass.academicYear', 'schoolClass.gradeLevel'])
            ->whereNull('teacher_id')->whereHas('subject')->whereHas('schoolClass')
            ->orderBy('class_id')->orderBy('sub_id')->paginate(20, ['*'], 'unassigned_page')->withQueryString();

        return view('academic.scheduleload.teacherload', [
            'loads' => $loads, 'unassigned' => $unassigned, 'search' => $search,
            'teachers' => Teacher::orderBy('name')->get(),
            'classes' => SchoolClass::with('academicYear', 'gradeLevel')->orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Gate::forUser($request->user('web'))->authorize('manage-loads');
        $data = $request->validate([
            'teacher_id' => ['required', 'integer', 'exists:teachers,id'],
            'class_id' => ['required', 'integer', 'exists:class,id'],
            'sub_id' => ['required', 'integer', 'exists:subject,id'],
        ]);
        DB::transaction(function () use ($data) {
            $class = SchoolClass::whereKey($data['class_id'])->lockForUpdate()->firstOrFail();
            if (!$class->acady_id) throw ValidationException::withMessages(['class_id' => 'The class needs a school year.']);
            $assignment = ClassSubject::where('class_id', $class->id)->where('sub_id', $data['sub_id'])->lockForUpdate()->first();
            if ($assignment?->teacher_id) throw ValidationException::withMessages(['sub_id' => 'This class and subject already has a teacher. Use Reassign instead.']);
            if ($assignment) $assignment->update(['teacher_id' => $data['teacher_id']]);
            else ClassSubject::create($data);
        });
        return back()->with('success', 'Teaching load saved.');
    }

    public function update(Request $request, ClassSubject $classSubject)
    {
        Gate::forUser($request->user('web'))->authorize('manage-loads');
        $data = $request->validate(['teacher_id' => ['required', 'integer', 'exists:teachers,id']]);
        if (! $classSubject->schoolClass?->acady_id) {
            throw ValidationException::withMessages(['teacher_id' => 'The class needs a school year before assigning a teacher.']);
        }
        $classSubject->update($data);
        return back()->with('success', 'Teaching load updated.');
    }

    public function destroy(ClassSubject $classSubject)
    {
        Gate::forUser(request()->user('web'))->authorize('manage-loads');
        $classSubject->update(['teacher_id' => null]);
        return back()->with('success', 'Teaching load removed.');
    }
}
