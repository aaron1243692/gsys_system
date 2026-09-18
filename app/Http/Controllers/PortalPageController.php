<?php
namespace App\Http\Controllers;
use App\Models\{SchoolClass,Student,StudentInfo,Grade,GradeSheet,GradeEncodingSchedule,GuardianChild};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,DB,Hash};
use Illuminate\Validation\Rule;
class PortalPageController extends Controller
{
    public function teacher(\App\Services\TeacherTeachingLoads $teachingLoads) {
        $id=Auth::guard('teacher')->id();
        $loads=$teachingLoads->forTeacher(Auth::guard('teacher')->user())->with('subject','schoolClass')->get();
        $classes=$loads->pluck('schoolClass')->unique('id');
        $studentCount=StudentInfo::where('admited',1)->whereHas('student')->whereIn('class_id',$classes->pluck('id'))->where(function($q) use($classes) {
            foreach($classes as $class) $q->orWhere(fn($c)=>$c->where('class_id',$class->id)->where('acady_id',$class->acady_id)->where('grlvl_id',$class->grlvl_id));
        })->distinct()->count('student_id');
        $advisoryClasses=SchoolClass::where('adviser_id',$id)->with('academicYear')->get();
        return view('portal.teacher.dashboard',['portal'=>'teacher','subjectCount'=>$loads->pluck('sub_id')->unique()->count(),'loadCount'=>$loads->count(),'studentCount'=>$studentCount,'advisoryClasses'=>$advisoryClasses,'sheets'=>GradeSheet::where('teacher_id',$id)->latest()->get(),'schedules'=>GradeEncodingSchedule::with('academicYear')->whereIn('academic_year_id',$classes->pluck('acady_id'))->get()]);
    }
    public function advisoryClass() {
        $id=Auth::guard('teacher')->id();
        $classes=SchoolClass::where('adviser_id',$id)->with(['academicYear','gradeLevel'])->orderBy('name')->get();
        abort_if($classes->isEmpty(),403,'You do not have an advisory class assignment.');
        $students=StudentInfo::where('admited',1)->whereHas('student')->where(function($query) use($classes) {
            foreach($classes as $class) $query->orWhere(fn($item)=>$item->where('class_id',$class->id)->where('acady_id',$class->acady_id)->where('grlvl_id',$class->grlvl_id));
        })->with('student')->orderBy('name')->get()->groupBy('class_id');
        return view('portal.teacher.advisory-class',compact('classes','students')+['portal'=>'teacher']);
    }
    public function history() { return view('portal.teacher.history',['portal'=>'teacher','sheets'=>GradeSheet::with(['approvedBy','returnedBy'])->where('teacher_id',Auth::guard('teacher')->id())->latest()->paginate(20)]); }
    public function student(Request $request) {
        $student=Auth::guard('student')->user()->student()->with('info.schoolClass.adviser','info.gradeLevel','info.academicYear')->firstOrFail();
        abort_if($request->has('student_id') && (string)$request->student_id!==(string)$student->id,403);
        return view('portal.student.dashboard',['portal'=>'student','student'=>$student,'gradeCount'=>Grade::recorded()->approved()->where('student_id',$student->id)->count()]);
    }
    public function subjects() {
        $info=Auth::guard('student')->user()->student?->info;
        $schoolClass=$info && $info->admited ? SchoolClass::whereKey($info->class_id)->where('acady_id',$info->acady_id)->where('grlvl_id',$info->grlvl_id)->with('adviser','academicYear','classSubjects.subject','classSubjects.teacher','classSchedules.room')->first() : null;
        return view('portal.student.subjects',['portal'=>'student','schoolClass'=>$schoolClass]);
    }
    public function guardian() {
        $guardianId=Auth::guard('guardian')->id();
        $verifiedIds=GuardianChild::where('guardian_id',$guardianId)->where('status','VERIFIED')->pluck('student_id');
        $children=Student::with(['info.gradeLevel','info.academicYear','info.schoolClass.adviser'])
            ->whereIn('id',$verifiedIds)->orderBy('username')->get();
        $approved=Grade::recorded()->approved()->whereIn('student_id',$verifiedIds)->get(['student_id','quarter'])->groupBy('student_id');
        $children->each(fn($child)=>$child->approvedQuarters=$approved->get($child->id,collect())->pluck('quarter')->unique()->sort()->values());
        return view('portal.guardian.dashboard',['portal'=>'guardian','children'=>$children,'childCount'=>$children->count(),
            'gradeCount'=>$approved->flatten(1)->count()]);
    }
    public function profile(Request $request) {
        $portal=$request->route('portal')??explode('.',$request->route()->getName())[0];
        if($portal==='admin') $portal='web';
        $identity=Auth::guard($portal)->user(); abort_unless($identity,403);
        return view($portal==='web'?'configuration.accounts.profile':'portal.profile',compact('portal','identity'));
    }
    public function updateProfile(Request $request) {
        $portal=explode('.',$request->route()->getName())[0]; if($portal==='admin') $portal='web';
        $identity=Auth::guard($portal)->user(); abort_unless($identity,403);
        $data=$request->validate(['email'=>['required','email','max:100',Rule::unique($identity->getTable(),'email')->ignore($identity->id)],'contact'=>['nullable','string','max:100'],'address'=>['nullable','string','max:255'],'current_password'=>['required','string'],'password'=>['nullable','string','min:8','max:255','confirmed']]);
        if(!Hash::check($data['current_password'],$identity->password)) throw \Illuminate\Validation\ValidationException::withMessages(['current_password'=>'Current password is incorrect.']);
        DB::transaction(function() use($identity,$portal,$data) {
            $identity->email=$data['email']; if(!empty($data['password'])) $identity->password=$data['password'];
            if($portal==='guardian') $identity->fill(array_intersect_key($data,array_flip(['contact','address'])));
            $identity->save();
            if($portal==='student') $identity->fill(array_intersect_key($data,array_flip(['contact','address'])))->save();
            \App\Services\Audit::record($portal,$identity->id,'profile.updated',$identity);
        });
        $request->session()->regenerate(); return back()->with('success','Profile updated.');
    }
}
