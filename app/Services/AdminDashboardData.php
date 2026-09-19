<?php
namespace App\Services;
use App\Models\{AcademicYear,ClassSubject,GradeEncodingSchedule,GradeSheet,Guardian,GuardianChild,SchoolClass,Student,StudentAccount,StudentInfo,Subject,Teacher};
use Illuminate\Support\Facades\{DB,Gate};
class AdminDashboardData
{
    public function headerNotifications():array
    {
        $years=$this->years();$year=$this->defaultYear($years);if(!$year)return [];
        $yearId=(int)$year->id;$schedules=GradeEncodingSchedule::where('academic_year_id',$yearId)->orderBy('quarter')->get();
        $submitted=GradeSheet::where('academic_year_id',$yearId)->where('status','SUBMITTED')->count();
        $loads=ClassSubject::whereHas('schoolClass',fn($q)=>$q->where('acady_id',$yearId));
        $unassigned=(clone $loads)->count()-(clone $loads)->whereNotNull('teacher_id')->whereHas('teacher')->count();
        $issues=array_sum($this->academicIssues());
        return $this->notifications($submitted,$unassigned,$issues,$schedules,['approve'=>Gate::allows('approve-grades'),'loads'=>Gate::allows('manage-loads'),'schedules'=>Gate::allows('manage-schedules')]);
    }
    public function build(?int $requestedYearId=null):array
    {
        $years=$this->years();$currentYear=$this->defaultYear($years);
        $year=$requestedYearId?$years->firstWhere('id',$requestedYearId):$currentYear;abort_unless($year,404,'Academic year not found.');
        $yearId=(int)$year->id;$now=now();
        $schedules=GradeEncodingSchedule::where('academic_year_id',$yearId)->orderBy('quarter')->get()->keyBy('quarter');
        $currentSchedule=$schedules->first(fn($s)=>$s->status==='OPEN')??$schedules->first(fn($s)=>$s->status==='UPCOMING')??$schedules->last();
        $quarter=(int)($currentSchedule?->quarter?:1);
        $sheetCounts=GradeSheet::where('academic_year_id',$yearId)->selectRaw('status,COUNT(*) total')->groupBy('status')->pluck('total','status');
        $loads=ClassSubject::query()->whereHas('schoolClass',fn($q)=>$q->where('acady_id',$yearId));
        $loadCount=(clone $loads)->count();$assigned=(clone $loads)->whereNotNull('teacher_id')->whereHas('teacher')->count();$unassigned=$loadCount-$assigned;
        $teachersWithLoads=(clone $loads)->whereNotNull('teacher_id')->whereHas('teacher')->distinct()->count('teacher_id');
        $expected=$loadCount;$started=GradeSheet::where('academic_year_id',$yearId)->where('quarter',$quarter)->count();
        $quarterCounts=GradeSheet::where('academic_year_id',$yearId)->where('quarter',$quarter)->selectRaw('status,COUNT(*) total')->groupBy('status')->pluck('total','status');
        $issues=$this->academicIssues();
        $submitted=GradeSheet::where('academic_year_id',$yearId)->where('status','SUBMITTED')->orderByDesc('submitted_at')->limit(5)->get();
        $unassignedRows=ClassSubject::with('subject','schoolClass.academicYear')->whereHas('schoolClass',fn($q)=>$q->where('acady_id',$yearId))->where(fn($q)=>$q->whereNull('teacher_id')->orWhereDoesntHave('teacher'))->limit(5)->get();
        $permissions=['approve'=>Gate::allows('approve-grades'),'loads'=>Gate::allows('manage-loads'),'schedules'=>Gate::allows('manage-schedules'),'accounts'=>Gate::allows('manage-registrations')];
        $notifications=$this->notifications((int)($sheetCounts['SUBMITTED']??0),$unassigned,array_sum($issues),$schedules,$permissions);
        return compact('years','year','currentYear','schedules','currentSchedule','quarter','sheetCounts','quarterCounts','submitted','unassignedRows','permissions','notifications')+[
            'summary'=>['students'=>StudentInfo::where('admited',1)->count(),'teachers'=>Teacher::count(),'guardians'=>Guardian::count(),'classes'=>SchoolClass::where('acady_id',$yearId)->count(),'subjects'=>$loadCount],
            'accounts'=>['students'=>$this->statuses(StudentAccount::query()),'guardians'=>$this->statuses(Guardian::query()),'teachers'=>$this->statuses(Teacher::query())],
            'loads'=>['total'=>$loadCount,'assigned'=>$assigned,'unassigned'=>$unassigned,'teachers_with'=>$teachersWithLoads,'teachers_without'=>max(0,Teacher::count()-$teachersWithLoads)],
            'issues'=>$issues,'issue_total'=>array_sum($issues),
            'guardianLinks'=>['guardians'=>Guardian::count(),'linked'=>Guardian::whereHas('children',fn($q)=>$q->where('status','VERIFIED'))->count(),'without'=>Guardian::whereDoesntHave('children',fn($q)=>$q->where('status','VERIFIED'))->count(),'relationships'=>GuardianChild::where('status','VERIFIED')->count()],
            'progress'=>['expected'=>$expected,'not_started'=>max(0,$expected-$started)],
            'recentActivity'=>$this->activity($yearId),
        ];
    }
    private function years(){return AcademicYear::query()->select('acady.*')->selectSub(fn($q)=>$q->from('stinfo')->selectRaw('COUNT(*)')->whereColumn('stinfo.acady_id','acady.id')->where('admited',1),'student_count')->orderByDesc('year_from')->orderByDesc('student_count')->get();}
    private function defaultYear($years){return $years->filter(fn($y)=>(int)$y->year_from<=(int)now()->year&&(int)$y->year_to>=(int)now()->year+1)->sortByDesc('student_count')->first()??$years->sortByDesc('student_count')->first();}
    private function statuses($query):array{return $query->selectRaw('status,COUNT(*) total')->groupBy('status')->pluck('total','status')->mapWithKeys(fn($v,$k)=>[$k=>(int)$v])->all();}
    private function academicIssues():array
    {
        return [
            'without_class'=>StudentInfo::where('admited',1)->where(fn($q)=>$q->whereNull('class_id')->orWhereDoesntHave('schoolClass')->orWhereHas('schoolClass',fn($class)=>$class->whereColumn('class.acady_id','!=','stinfo.acady_id')->orWhereColumn('class.grlvl_id','!=','stinfo.grlvl_id')))->count(),
            'without_year'=>StudentInfo::where('admited',1)->where(fn($q)=>$q->whereNull('acady_id')->orWhereDoesntHave('academicYear'))->count(),
            'without_grade_level'=>StudentInfo::where('admited',1)->where(fn($q)=>$q->whereNull('grlvl_id')->orWhereDoesntHave('gradeLevel'))->count(),
            'without_portal_account'=>Student::whereHas('info',fn($q)=>$q->where('admited',1))->whereDoesntHave('portalAccount')->count(),
        ];
    }
    private function notifications(int $submitted,int $unassigned,int $issues,$schedules,array $permissions):array
    {
        $items=[];if($submitted)$items[]=['priority'=>'attention','text'=>"$submitted grade sheet".($submitted===1?' is':'s are').' waiting for approval.','route'=>$permissions['approve']?'report.grades.approval':null,'label'=>'Review'];
        if($unassigned)$items[]=['priority'=>'attention','text'=>"$unassigned subject load".($unassigned===1?' needs':'s need').' an assigned teacher.','route'=>$permissions['loads']?'academic.schedule-load.teacher-load':null,'label'=>'Manage'];
        if($issues)$items[]=['priority'=>'attention','text'=>"$issues academic placement issue".($issues===1?' requires':'s require').' review.','route'=>'academic.students.index','label'=>'Review'];
        foreach($schedules as $s){if($s->status==='OPEN'&&now()->diffInHours($s->closes_at,false)<=72)$items[]=['priority'=>'warning','text'=>'Q'.$s->quarter.' encoding closes '.$s->closes_at->format('M j, Y g:i A').'.','route'=>$permissions['schedules']?'configuration.grade-encoding-schedule':null,'label'=>'Schedule'];elseif($s->status==='UPCOMING')$items[]=['priority'=>'information','text'=>'Q'.$s->quarter.' encoding opens '.$s->opens_at->format('M j, Y g:i A').'.','route'=>$permissions['schedules']?'configuration.grade-encoding-schedule':null,'label'=>'Schedule'];}
        return $items;
    }
    private function activity(int $yearId)
    {
        $items=collect();foreach(GradeSheet::where('academic_year_id',$yearId)->latest('updated_at')->limit(12)->get() as $s){foreach([['submitted_at','Submitted'],['approved_at','Approved'],['returned_at','Returned']] as [$field,$verb])if($s->$field)$items->push(['actor'=>$verb==='Submitted'?($s->teacher_name?:'Teacher'):'Admin','action'=>"$verb {$s->subject_name} — {$s->class_name} — Q{$s->quarter}",'at'=>$s->$field]);}return $items->sortByDesc('at')->take(8)->values();
    }
}
