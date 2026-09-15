<?php
namespace App\Http\Controllers;
use App\Models\{SchoolClass,StudentInfo,Grade,GradeSheet,GradeEncodingSchedule,GuardianChild};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,DB,Hash};
use Illuminate\Validation\Rule;
class PortalPageController extends Controller
{
    public function teacher() {
        $id=Auth::guard('teacher')->id();
        $classes=SchoolClass::whereHas('classSubjects.subject',fn($q)=>$q->where('teacher_id',$id))->get();
        return view('portal.teacher.dashboard',['portal'=>'teacher','classes'=>$classes,'subjectCount'=>Auth::guard('teacher')->user()->subjects()->count(),'studentCount'=>StudentInfo::whereIn('class_id',$classes->pluck('id'))->where('admited',1)->distinct()->count('student_id'),'sheets'=>GradeSheet::where('teacher_id',$id)->latest()->get(),'schedules'=>GradeEncodingSchedule::with('academicYear')->whereIn('academic_year_id',$classes->pluck('acady_id'))->get()]);
    }
    public function history() { return view('portal.teacher.history',['portal'=>'teacher','sheets'=>GradeSheet::where('teacher_id',Auth::guard('teacher')->id())->latest()->paginate(20)]); }
    public function student(Request $request) {
        $student=Auth::guard('student')->user();
        abort_if($request->has('student_id') && (string)$request->student_id!==(string)$student->id,403);
        return view('portal.student.dashboard',['portal'=>'student','student'=>$student->load('info.schoolClass','info.gradeLevel','info.academicYear'),'gradeCount'=>Grade::recorded()->approved()->where('student_id',$student->id)->count()]);
    }
    public function subjects() {
        $info=Auth::guard('student')->user()->info;
        $schoolClass=$info && $info->admited ? SchoolClass::whereKey($info->class_id)->where('acady_id',$info->acady_id)->where('grlvl_id',$info->grlvl_id)->with('classSubjects.subject')->first() : null;
        return view('portal.student.subjects',['portal'=>'student','schoolClass'=>$schoolClass]);
    }
    public function guardian() {
        $links=GuardianChild::where('guardian_id',Auth::guard('guardian')->id())->where('status','VERIFIED');
        return view('portal.guardian.dashboard',['portal'=>'guardian','childCount'=>(clone $links)->count(),'gradeCount'=>Grade::approved()->whereIn('student_id',$links->select('student_id'))->count()]);
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
            if($portal==='student') $identity->info()->update(array_intersect_key($data,array_flip(['contact','address'])));
            \App\Services\Audit::record($portal,$identity->id,'profile.updated',$identity);
        });
        $request->session()->regenerate(); return back()->with('success','Profile updated.');
    }
}
