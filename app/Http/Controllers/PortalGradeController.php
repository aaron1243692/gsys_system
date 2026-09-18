<?php

namespace App\Http\Controllers;

use App\Models\{GuardianChild, Student, Grade, SchoolClass, AcademicYear};
use App\Services\GradeReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalGradeController extends Controller
{
    public function student(Request $request, GradeReport $report)
    {
        $student = Auth::guard('student')->user()->student()->with('info')->firstOrFail();
        abort_if($request->has('student_id') && (string) $request->input('student_id') !== (string) $student->id, 403);

        return view('portal.grades', $report->data($request, $student->id) + ['portal' => 'student', 'student' => $student]);
    }

    public function children()
    {
        $links = GuardianChild::where('guardian_id', Auth::guard('guardian')->id())->where('status', 'VERIFIED')->get()->keyBy('student_id');
        $children = Student::with(['info.gradeLevel','info.academicYear','info.schoolClass.adviser','info.schoolClass.classSubjects.subject','info.schoolClass.classSubjects.teacher','info.schoolClass.classSchedules.room'])
            ->whereIn('id', $links->keys())
            ->orderBy('username')->paginate(20);
        $children->getCollection()->each(fn ($child) => $child->guardianRelationship = $links->get($child->id)?->relationship);

        return view('portal.guardian.children', ['portal' => 'guardian', 'children' => $children]);
    }

    public function child(Request $request, Student $student)
    {
        abort_unless(GuardianChild::where('guardian_id', Auth::guard('guardian')->id())->where('status','VERIFIED')->where('student_id', $student->id)->exists(), 403);
        abort_if($request->has('student_id') && (string) $request->input('student_id') !== (string) $student->id, 403);

        $student->load('info.gradeLevel', 'info.academicYear');
        $filters = $request->validate(['academic_year_id' => ['nullable', 'integer', 'min:1']]);
        $approved = Grade::recorded()->approved()->where('student_id', $student->id);
        $yearIds = (clone $approved)->distinct()->pluck('academic_year_id');
        if ($student->info?->acady_id) $yearIds->push($student->info->acady_id);
        $years = AcademicYear::whereIn('id', $yearIds->filter()->unique())->orderByDesc('id')->get();
        // Open the latest year with an approved grade by default. Current enrollment
        // may be in a newer year with no grades yet.
        $latestApprovedYearId = (clone $approved)->orderByDesc('academic_year_id')->value('academic_year_id');
        $yearId = (int) ($filters['academic_year_id'] ?? ($latestApprovedYearId ?: $student->info?->acady_id ?: $years->first()?->id));
        abort_if($yearId && ! $years->contains('id', $yearId), 404);
        $grades = (clone $approved)->where('academic_year_id', $yearId)->get();
        $classIds = $grades->pluck('class_id')->filter()->unique();
        if ($student->info?->acady_id == $yearId && $student->info?->class_id) $classIds->push($student->info->class_id);
        $classes = SchoolClass::with('gradeLevel', 'academicYear', 'adviser', 'classSubjects.subject', 'classSubjects.teacher')
            ->whereIn('id', $classIds->unique())->where('acady_id', $yearId)->get();
        return view('portal.guardian.academic-record', compact('student', 'years', 'yearId', 'grades', 'classes') + ['portal' => 'guardian']);
    }
}
