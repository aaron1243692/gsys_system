<?php
namespace App\Services;
use App\Models\{GradeSheet,GradeEncodingSchedule};
class GradeWorkflow
{
    public function editable(?GradeSheet $sheet,int $year,int $quarter): bool
    {
        if(!in_array($quarter,[1,2,3],true) || !in_array($quarter,config('grading.editable_quarters'),true)) return false;
        if($sheet && in_array($sheet->status,['SUBMITTED','APPROVED'],true)) return false;
        if($sheet?->status==='RETURNED') return $sheet->correction_until && now()->lte($sheet->correction_until);
        return GradeEncodingSchedule::where('academic_year_id',$year)->where('quarter',$quarter)->where('opens_at','<=',now())->where('closes_at','>=',now())->exists();
    }
    public function assertComplete(GradeSheet $sheet): void
    {
        $ids=collect($sheet->roster)->map(fn($id)=>(int)$id)->sort()->values();
        $grades=$sheet->grades()->get();
        abort_unless($ids->isNotEmpty() && $grades->pluck('student_id')->map(fn($id)=>(int)$id)->sort()->values()->all()===$ids->all(),422,'Every enrolled student must have a final grade before submission.');
        foreach($grades as $grade) \Illuminate\Support\Facades\Validator::make(['grade'=>$grade->grade],['grade'=>array_merge(['required'],app(GradingRules::class)->gradeRules())])->validate();
    }
}
