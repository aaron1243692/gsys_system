<?php
namespace App\Services;
use App\Models\{GradeSheet, GradeEncodingSchedule, SchoolClass, Subject, Teacher};
class GradeWorkflow
{
    public function assertTeacherAssignment(int $teacherId, SchoolClass $schoolClass, Subject $subject): void
    {
        $teacher = Teacher::find($teacherId);
        abort_unless($teacher && $schoolClass->acady_id && app(TeacherTeachingLoads::class)
            ->owns($teacher, $schoolClass->id, $subject->id),
            403, 'This teaching load is not assigned to your account.');
    }

    public function editingDecision(?GradeSheet $sheet, int $year, int $quarter, ?GradeEncodingSchedule $schedule = null): array
    {
        // A controller that already looked up (or locked) the schedule must use that
        // exact result, including null. Only callers omitting the argument query here.
        if (func_num_args() < 4) {
            $schedule = GradeEncodingSchedule::where('academic_year_id', $year)->where('quarter', $quarter)->first();
        }
        $period = $schedule?->status ?? 'NOT CONFIGURED';
        $result = fn (bool $allowed, string $reason) => ['allowed' => $allowed, 'reason' => $reason, 'period' => $period];
        if (!in_array($quarter, [1, 2, 3], true) || !in_array($quarter, config('grading.editable_quarters'), true))
            return $result(false, 'This quarter is unavailable for grade encoding.');
        if ($sheet?->status === 'SUBMITTED') return $result(false, 'This grade sheet has already been submitted and is waiting for approval.');
        if ($sheet?->status === 'APPROVED') return $result(false, 'This grade sheet has already been approved.');
        if ($sheet?->status === 'RETURNED')
            return $sheet->correction_until && now()->lte($sheet->correction_until)
                ? $result(true, 'Correction access is open.')
                : $result(false, 'Correction access has expired.');
        if (!$schedule) return $result(false, 'No encoding schedule is configured for this class school year and quarter.');
        if ($period === 'UPCOMING') return $result(false, 'Grade encoding has not opened yet.');
        if ($period === 'CLOSED') return $result(false, 'The grade encoding period has closed.');
        return $result(true, 'Grade encoding is open.');
    }

    public function editable(?GradeSheet $sheet,int $year,int $quarter): bool
    {
        return $this->editingDecision($sheet, $year, $quarter)['allowed'];
    }
    public function assertComplete(GradeSheet $sheet): void
    {
        $ids=collect($sheet->roster)->map(fn($id)=>(int)$id)->sort()->values();
        $grades=$sheet->grades()->get();
        abort_unless($ids->isNotEmpty() && $grades->pluck('student_id')->map(fn($id)=>(int)$id)->sort()->values()->all()===$ids->all(),422,'Every enrolled student must have a final grade before submission.');
        $rules=array_values(array_filter(app(GradingRules::class)->gradeRules(), fn($rule)=>$rule!=='nullable'));
        foreach($grades as $grade) \Illuminate\Support\Facades\Validator::make(['grade'=>$grade->grade],['grade'=>array_merge(['required'],$rules)])->validate();
    }
}
