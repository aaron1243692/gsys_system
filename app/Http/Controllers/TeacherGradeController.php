<?php

namespace App\Http\Controllers;

use App\Models\{ClassSubject, Grade, SchoolClass, StudentInfo, Subject};
use App\Services\GradingRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Validator};
use Illuminate\Validation\ValidationException;

class TeacherGradeController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search'));
        $classes = SchoolClass::with(['academicYear', 'classSubjects.subject'])
            ->whereHas('classSubjects.subject', fn ($q) => $q->where('teacher_id', Auth::guard('teacher')->id()))
            ->when($search !== '', fn ($q) => $q->where('name', 'like', '%'.$search.'%'))
            ->orderBy('name')->paginate(15)->withQueryString();

        return view('portal.teacher.classes', ['portal' => 'teacher', 'classes' => $classes, 'search' => $search]);
    }

    private function authorizeAssignment(SchoolClass $schoolClass, Subject $subject): void
    {
        abort_unless((int) $subject->teacher_id === (int) Auth::guard('teacher')->id()
            && ClassSubject::where('class_id', $schoolClass->id)->where('sub_id', $subject->id)->exists(), 403);
    }

    private function roster(SchoolClass $schoolClass)
    {
        return StudentInfo::where('class_id', $schoolClass->id)->where('admited', 1)
            ->where('acady_id', $schoolClass->acady_id)->where('grlvl_id', $schoolClass->grlvl_id)
            ->whereHas('student');
    }

    public function show(Request $request, SchoolClass $schoolClass, Subject $subject, GradingRules $rules)
    {
        $this->authorizeAssignment($schoolClass, $subject);
        $validated = $request->validate(['quarter' => ['sometimes', 'integer', 'in:1,2,3']]);
        $quarter = (int) ($validated['quarter'] ?? 1);
        $students = $this->roster($schoolClass)->orderBy('name')->get()->unique('student_id');
        $grades = Grade::recorded()->where('class_id', $schoolClass->id)->where('subject_id', $subject->id)
            ->where('academic_year_id', $schoolClass->acady_id)->where('quarter', $quarter)->get()->keyBy('student_id');
        $excluded = StudentInfo::where('class_id', $schoolClass->id)->where('admited', 1)->count() - $students->count();

        return view('portal.teacher.entry', compact('schoolClass', 'subject', 'quarter', 'students', 'grades', 'excluded') + [
            'portal' => 'teacher', 'editable' => in_array($quarter, config('grading.editable_quarters'), true),
        ]);
    }

    public function store(Request $request, SchoolClass $schoolClass, Subject $subject, GradingRules $rules)
    {
        $this->authorizeAssignment($schoolClass, $subject);
        $validated = $request->validate([
            'quarter' => ['required', 'integer', 'in:1,2,3'],
            'academic_year_id' => ['required', 'integer'],
            'complete' => ['required', 'accepted'],
            'rows' => ['required', 'array', 'min:1', 'max:1000'],
            'rows.*' => ['required', 'array:student_id,grade,remarks'],
            'rows.*.student_id' => ['required', 'integer', 'distinct'],
        ]);
        $quarter = (int) $validated['quarter'];
        $rules->assertEditable($quarter);

        DB::transaction(function () use ($schoolClass, $subject, $validated, $quarter, $rules) {
            // Serializes bulk saves for a class and rechecks assignment/placement after locking.
            $schoolClass = SchoolClass::whereKey($schoolClass->id)->lockForUpdate()->firstOrFail();
            $subject = Subject::whereKey($subject->id)->lockForUpdate()->firstOrFail();
            $this->authorizeAssignment($schoolClass, $subject);
            abort_unless($schoolClass->acady_id && (int) $validated['academic_year_id'] === (int) $schoolClass->acady_id, 403, 'Class school year changed. Reload the grade sheet.');
            $students = $this->roster($schoolClass)->lockForUpdate()->get()->keyBy('student_id');
            $errors = [];
            $nonempty = 0;
            foreach ($validated['rows'] as $index => $row) {
                abort_unless($students->has($row['student_id']), 403, 'Student is not enrolled in this class and school year.');
                $name = $students[$row['student_id']]->name;
                $validator = Validator::make($row, [
                    'grade' => $rules->gradeRules(),
                    'remarks' => ['nullable', 'string', 'max:50'],
                ]);
                foreach ($validator->errors()->messages() as $field => $messages) {
                    $errors["rows.$index.$field"] = array_map(fn ($message) => $name.': '.$message, $messages);
                }
                if (($row['grade'] ?? null) !== null && $row['grade'] !== '') {
                    $nonempty++;
                }
            }
            if ($errors) {
                throw ValidationException::withMessages($errors);
            }
            if (! $nonempty) {
                throw ValidationException::withMessages(['rows' => 'Enter at least one grade. Blank grades leave existing records unchanged.']);
            }
            $teacher = Auth::guard('teacher')->user();
            $schoolClass->load(['academicYear', 'gradeLevel']);
            abort_unless($schoolClass->academicYear && $schoolClass->gradeLevel, 422, 'Class academic year or grade level is missing.');

            foreach ($validated['rows'] as $row) {
                if (($row['grade'] ?? null) === null || $row['grade'] === '') {
                    continue;
                }
                $key = ['student_id' => $row['student_id'], 'class_id' => $schoolClass->id,
                    'subject_id' => $subject->id, 'academic_year_id' => $schoolClass->acady_id];
                $grade = Grade::firstOrNew($key + ['quarter' => $quarter]);
                if (! $grade->exists) {
                    $previous = Grade::recorded()->where($key)->orderBy('id')->first();
                    $grade->fill([
                        'teacher_id' => $teacher->id, 'created_by' => $teacher->id,
                        'teacher_name' => $teacher->name,
                        'student_name' => $previous?->student_name ?? $students[$row['student_id']]->name,
                        'class_name' => $previous?->class_name ?? $schoolClass->name,
                        'subject_name' => $previous?->subject_name ?? $subject->name,
                        'academic_year_name' => $previous?->academic_year_name ?? $schoolClass->academicYear->name,
                        'grade_level_id' => $previous?->grade_level_id ?? $schoolClass->grlvl_id,
                        'grade_level_name' => $previous?->grade_level_name ?? $schoolClass->gradeLevel->name,
                    ]);
                }
                $grade->fill(['grade' => $row['grade'], 'remarks' => $row['remarks'] ?? null, 'updated_by' => $teacher->id])->save();
            }
        });

        return redirect()->route('teacher.grades', [$schoolClass, $subject, 'quarter' => $quarter])->with('success', 'Grades saved.');
    }
}
