<?php

namespace App\Http\Controllers;

use App\Models\{ClassSubject, Grade, GradeSheet, GradeEncodingSchedule, SchoolClass, StudentInfo, Subject};
use App\Services\{GradeWorkflow, Audit, TeacherTeachingLoads};
use App\Services\GradingRules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Validator};
use Illuminate\Validation\ValidationException;

class TeacherGradeController extends Controller
{
    public function index(Request $request, TeacherTeachingLoads $teachingLoads)
    {
        $search = trim((string) $request->query('search'));
        $loads = $teachingLoads->forTeacher(Auth::guard('teacher')->user())
            ->with(['subject', 'schoolClass.academicYear', 'schoolClass.gradeLevel', 'schoolClass.classSchedules.room'])
            ->when($search !== '', fn ($query) => $query->where(fn ($query) => $query
                ->whereHas('subject', fn ($subject) => $subject->where('name', 'like', '%'.$search.'%'))
                ->orWhereHas('schoolClass', fn ($class) => $class->where('name', 'like', '%'.$search.'%'))))
            ->orderBy('class_id')->orderBy('sub_id')->paginate(15)->withQueryString();
        $loads->getCollection()->each(function (ClassSubject $load): void {
            $load->studentCount = $this->roster($load->schoolClass)->distinct()->count('student_id');
            $load->loadSchedules = $load->schoolClass->classSchedules->where('subject_id', $load->sub_id)->values();
            $load->gradeSheets = GradeSheet::where('teacher_id', Auth::guard('teacher')->id())
                ->where('class_id', $load->class_id)->where('subject_id', $load->sub_id)
                ->where('academic_year_id', $load->schoolClass->acady_id)->get()->keyBy('quarter');
        });

        return view('portal.teacher.subjects', ['portal' => 'teacher', 'loads' => $loads, 'search' => $search]);
    }

    public function students(ClassSubject $classSubject)
    {
        abort_unless(app(TeacherTeachingLoads::class)->forTeacher(Auth::guard('teacher')->user())
            ->whereKey($classSubject->id)->exists(), 403);
        $classSubject->load(['teacher', 'subject', 'schoolClass.academicYear']);
        abort_unless($classSubject->subject && $classSubject->schoolClass?->acady_id, 404);
        $students = $this->roster($classSubject->schoolClass)->with('student')->orderBy('name')->paginate(30);

        return view('portal.teacher.subject-students', [
            'portal' => 'teacher', 'load' => $classSubject, 'students' => $students,
        ]);
    }

    public function gradeIndex(TeacherTeachingLoads $teachingLoads)
    {
        $loads = $teachingLoads->forTeacher(Auth::guard('teacher')->user())
            ->with(['subject', 'schoolClass.academicYear'])
            ->orderBy('class_id')->orderBy('sub_id')->get();

        return view('portal.teacher.grades-index', ['portal' => 'teacher', 'loads' => $loads]);
    }

    private function authorizedLoad(ClassSubject $classSubject): ClassSubject
    {
        abort_unless(app(TeacherTeachingLoads::class)->forTeacher(Auth::guard('teacher')->user())
            ->whereKey($classSubject->id)->exists(), 403, 'This teaching load is not assigned to your account.');

        return $classSubject->loadMissing(['subject', 'schoolClass.academicYear', 'schoolClass.gradeLevel']);
    }

    private function roster(SchoolClass $schoolClass)
    {
        return StudentInfo::where('class_id', $schoolClass->id)->where('admited', 1)
            ->where('acady_id', $schoolClass->acady_id)->where('grlvl_id', $schoolClass->grlvl_id)
            ->whereHas('student');
    }

    public function legacyGradeRoute(SchoolClass $schoolClass, Subject $subject)
    {
        $load = $this->legacyLoad($schoolClass, $subject);

        return redirect()->route('teacher.grades', $load);
    }

    public function legacyGradeStore(Request $request, SchoolClass $schoolClass, Subject $subject, GradingRules $rules)
    {
        return $this->store($request, $this->legacyLoad($schoolClass, $subject), $rules);
    }

    private function legacyLoad(SchoolClass $schoolClass, Subject $subject): ClassSubject
    {
        $load = app(TeacherTeachingLoads::class)->forTeacher(Auth::guard('teacher')->user())
            ->where('class_id', $schoolClass->id)->where('sub_id', $subject->id)->first();
        abort_unless($load, 403, 'This teaching load is not assigned to your account.');

        return $load;
    }

    public function show(Request $request, ClassSubject $classSubject, GradingRules $rules)
    {
        $classSubject = $this->authorizedLoad($classSubject);
        $schoolClass = $classSubject->schoolClass;
        $subject = $classSubject->subject;
        $validated = $request->validate(['quarter' => ['sometimes', 'integer', 'in:1,2,3']]);
        $quarter = (int) ($validated['quarter'] ?? 1);
        $students = $this->roster($schoolClass)->with('student')->orderBy('name')->get()->unique('student_id');
        $sheet = GradeSheet::where(['teacher_id'=>Auth::guard('teacher')->id(),'class_id'=>$schoolClass->id,'subject_id'=>$subject->id,'academic_year_id'=>$schoolClass->acady_id,'quarter'=>$quarter])->first();
        $schedule = GradeEncodingSchedule::where('academic_year_id',$schoolClass->acady_id)->where('quarter',$quarter)->first();
        $editing = app(GradeWorkflow::class)->editingDecision($sheet, (int) $schoolClass->acady_id, $quarter, $schedule);
        $grades = Grade::recorded()->where('class_id', $schoolClass->id)->where('subject_id', $subject->id)
            ->where('academic_year_id', $schoolClass->acady_id)->where('quarter', $quarter)
            ->where('teacher_id', Auth::guard('teacher')->id())
            ->whereIn('student_id', $students->pluck('student_id'))->get()->keyBy('student_id');
        $excluded = StudentInfo::where('class_id', $schoolClass->id)->where('admited', 1)->count() - $students->count();

        return view('portal.teacher.entry', compact('classSubject', 'schoolClass', 'subject', 'quarter', 'students', 'grades', 'excluded','sheet','schedule') + [
            'portal' => 'teacher', 'editable' => $editing['allowed'], 'editing' => $editing,
        ]);
    }

    public function store(Request $request, ClassSubject $classSubject, GradingRules $rules)
    {
        $classSubject = $this->authorizedLoad($classSubject);
        $schoolClass = $classSubject->schoolClass;
        $subject = $classSubject->subject;
        $validated = $request->validate([
            'quarter' => ['required', 'integer', 'in:1,2,3'],
            'action' => ['sometimes', 'in:draft,submit'],
            'academic_year_id' => ['required', 'integer'],
            'complete' => ['required', 'accepted'],
            'rows' => ['required', 'array', 'min:1', 'max:1000'],
            'rows.*' => ['required', 'array:student_id,grade,remarks'],
            'rows.*.student_id' => ['required', 'integer', 'distinct'],
        ]);
        $quarter = (int) $validated['quarter'];
        DB::transaction(function () use ($classSubject, $schoolClass, $subject, $validated, $quarter, $rules) {
            // Serializes bulk saves for a class and rechecks assignment/placement after locking.
            $schoolClass = SchoolClass::whereKey($schoolClass->id)->lockForUpdate()->firstOrFail();
            $subject = Subject::whereKey($subject->id)->lockForUpdate()->firstOrFail();
            $this->authorizedLoad(ClassSubject::whereKey($classSubject->id)->lockForUpdate()->firstOrFail());
            abort_unless($schoolClass->acady_id && (int) $validated['academic_year_id'] === (int) $schoolClass->acady_id, 403, 'Class school year changed. Reload the grade sheet.');
            $students = $this->roster($schoolClass)->lockForUpdate()->get()->keyBy('student_id');
            $identity=['teacher_id'=>Auth::guard('teacher')->id(),'class_id'=>$schoolClass->id,'subject_id'=>$subject->id,'academic_year_id'=>$schoolClass->acady_id,'quarter'=>$quarter];
            $sheet=GradeSheet::where($identity)->lockForUpdate()->first();
            // Lock the schedule row so schedule changes and saves serialize.
            $schedule = GradeEncodingSchedule::where('academic_year_id',$schoolClass->acady_id)->where('quarter',$quarter)->lockForUpdate()->first();
            $editing = app(GradeWorkflow::class)->editingDecision($sheet, (int) $schoolClass->acady_id, $quarter, $schedule);
            abort_unless($editing['allowed'], 403, $editing['reason']);
            // Submitted rows must still belong to this class and school year.
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
            if(!$sheet) {
                $sheet=GradeSheet::create($identity+['roster'=>$students->keys()->values()->all(),'teacher_name'=>$teacher->name,'class_name'=>$schoolClass->name,'subject_name'=>$subject->name,'academic_year_name'=>$schoolClass->academicYear->name,'grade_level_id'=>$schoolClass->grlvl_id,'grade_level_name'=>$schoolClass->gradeLevel->name]);
            } elseif($sheet->status==='DRAFT') {
                $sheet->roster=$students->keys()->values()->all(); $sheet->save();
            }

            foreach ($validated['rows'] as $row) {
                if (($row['grade'] ?? null) === null || $row['grade'] === '') {
                    continue;
                }
                $key = ['student_id' => $row['student_id'], 'class_id' => $schoolClass->id,
                    'subject_id' => $subject->id, 'academic_year_id' => $schoolClass->acady_id];
                $grade = Grade::firstOrNew($key + ['quarter' => $quarter]);
                abort_if($grade->exists && $grade->teacher_id && (int)$grade->teacher_id !== (int)$teacher->id,
                    409, 'A historical grade belongs to another teacher. Staff must resolve the assignment.');
                abort_if($grade->exists && $grade->grade_sheet_id && (int)$grade->grade_sheet_id !== (int)$sheet->id,409,'A historical grade already belongs to another teacher’s sheet. Staff must resolve the assignment.');
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
                $grade->fill(['grade_sheet_id'=>$sheet->id,'grade' => $row['grade'], 'remarks' => $row['remarks'] ?? null, 'updated_by' => $teacher->id])->save();
            }
            Audit::record('teacher',$teacher->id,'sheet.draft_saved',$sheet);
            if(($validated['action']??'draft')==='submit') {
                app(GradeWorkflow::class)->assertComplete($sheet);
                $resubmitted = $sheet->status === 'RETURNED';
                $sheet->fill(['status'=>'SUBMITTED','submitted_by'=>$teacher->id,'submitted_at'=>now(),
                    'returned_by'=>null,'returned_at'=>null,'return_reason'=>null,'correction_until'=>null])->save();
                Audit::record('teacher',$teacher->id,$resubmitted ? 'sheet.resubmitted' : 'sheet.submitted',$sheet);
            }
        });

        return redirect()->route('teacher.grades', [$classSubject, 'quarter' => $quarter])->with('success', ($validated['action']??'draft')==='submit' ? 'Grade sheet submitted for review.' : 'Draft saved.');
    }
}
