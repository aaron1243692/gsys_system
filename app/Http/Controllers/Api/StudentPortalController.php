<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Services\MobileAcademicData;
use Illuminate\Http\{JsonResponse,Request};
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class StudentPortalController extends Controller
{
    private function account(Request $r){return $r->attributes->get('mobile_user');}
    private function student(Request $r){return $this->account($r)->student()->with('portalAccount','info.gradeLevel','info.academicYear','info.schoolClass')->firstOrFail();}
    public function dashboard(Request $r,MobileAcademicData $d):JsonResponse{$s=$this->student($r);return response()->json(['success'=>true,'data'=>['student'=>$d->studentSummary($s),'subject_count'=>count($d->currentSubjects($s)),'approved_grade_count'=>\App\Models\Grade::recorded()->approved()->where('student_id',$s->id)->count()]]);}
    public function subjects(Request $r,MobileAcademicData $d):JsonResponse{return response()->json(['success'=>true,'data'=>$d->currentSubjects($this->student($r))]);}
    public function grades(Request $r,MobileAcademicData $d):JsonResponse{$v=$r->validate(['school_year_id'=>['nullable','integer','min:1']]);return response()->json(['success'=>true,'data'=>$d->gradeRecord($this->student($r),$v['school_year_id']??null)]);}
    public function profile(Request $r,MobileAcademicData $d):JsonResponse{return response()->json(['success'=>true,'data'=>$d->studentSummary($this->student($r))]);}
    public function updateProfile(Request $r):JsonResponse
    {
        $a=$this->account($r);$v=$r->validate(['email'=>['required','email','max:100',Rule::unique('student_accounts','email')->ignore($a->id)],'contact'=>['nullable','string','max:100'],'address'=>['nullable','string','max:255'],'current_password'=>['required','string'],'password'=>['nullable','string','min:8','max:255','confirmed']]);
        if(!Hash::check($v['current_password'],$a->password))return response()->json(['success'=>false,'message'=>'Current password is incorrect.','errors'=>['current_password'=>['Current password is incorrect.']]],422);
        $a->fill($v);if(!empty($v['password']))$a->password=$v['password'];$a->save();
        return response()->json(['success'=>true,'message'=>'Profile updated.','data'=>['email'=>$a->email,'contact'=>$a->contact,'address'=>$a->address]]);
    }
}
