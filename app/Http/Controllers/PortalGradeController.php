<?php

namespace App\Http\Controllers;

use App\Models\{GuardianChild, Student};
use App\Services\GradeReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortalGradeController extends Controller
{
    public function student(Request $request, GradeReport $report)
    {
        $student = Auth::guard('student')->user();
        abort_if($request->has('student_id') && (string) $request->input('student_id') !== (string) $student->id, 403);

        return view('portal.grades', $report->data($request, $student->id) + ['portal' => 'student', 'student' => $student]);
    }

    public function children()
    {
        $children = Student::with('info')->whereIn('id', GuardianChild::where('guardian_id', Auth::guard('guardian')->id())->where('status','VERIFIED')->select('student_id'))
            ->orderBy('username')->paginate(20);

        return view('portal.guardian.children', ['portal' => 'guardian', 'children' => $children,'requests'=>GuardianChild::where('guardian_id',Auth::guard('guardian')->id())->where('status','!=','VERIFIED')->get()]);
    }

    public function child(Request $request, Student $student, GradeReport $report)
    {
        abort_unless(GuardianChild::where('guardian_id', Auth::guard('guardian')->id())->where('status','VERIFIED')->where('student_id', $student->id)->exists(), 403);
        abort_if($request->has('student_id') && (string) $request->input('student_id') !== (string) $student->id, 403);

        return view('portal.grades', $report->data($request, $student->id) + ['portal' => 'guardian', 'student' => $student]);
    }
}
