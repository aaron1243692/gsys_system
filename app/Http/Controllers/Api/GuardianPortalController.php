<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\{Grade,GuardianChild,Student};
use App\Services\MobileAcademicData;
use Illuminate\Http\{JsonResponse,Request};
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class GuardianPortalController extends Controller
{
    private function guardian(Request $r){return $r->attributes->get('mobile_user');}
    private function authorizeChild(Request $r,Student $student):GuardianChild
    {
        $link=GuardianChild::where('guardian_id',$this->guardian($r)->id)->where('student_id',$student->id)->where('status','VERIFIED')->first();
        abort_unless($link,403,'This student is not linked to your account.');return $link;
    }
    public function dashboard(Request $r,MobileAcademicData $d):JsonResponse{$children=$d->guardianChildren($this->guardian($r)->id);$childIds=collect($children)->pluck('id');return response()->json(['success'=>true,'data'=>['guardian'=>$this->profileData($this->guardian($r)),'child_count'=>count($children),'approved_grade_count'=>Grade::recorded()->approved()->whereIn('student_id',$childIds)->count(),'children'=>$children]]);}
    public function children(Request $r,MobileAcademicData $d):JsonResponse{return response()->json(['success'=>true,'data'=>$d->guardianChildren($this->guardian($r)->id)]);}
    public function child(Request $r,Student $student,MobileAcademicData $d):JsonResponse{$link=$this->authorizeChild($r,$student);return response()->json(['success'=>true,'data'=>$d->studentSummary($student->load('portalAccount','info.gradeLevel','info.academicYear','info.schoolClass'))+['relationship'=>$link->relationship]]);}
    public function grades(Request $r,Student $student,MobileAcademicData $d):JsonResponse{$link=$this->authorizeChild($r,$student);$v=$r->validate(['school_year_id'=>['nullable','integer','min:1']]);$record=$d->gradeRecord($student->load('portalAccount','info.gradeLevel','info.academicYear','info.schoolClass'),$v['school_year_id']??null);$record['relationship']=$link->relationship;return response()->json(['success'=>true,'data'=>$record]);}
    public function profile(Request $r):JsonResponse{return response()->json(['success'=>true,'data'=>$this->profileData($this->guardian($r))]);}
    public function updateProfile(Request $r):JsonResponse
    {
        $a=$this->guardian($r);$v=$r->validate(['name'=>['required','string','max:150'],'email'=>['required','email','max:100',Rule::unique('guardians','email')->ignore($a->id)],'contact'=>['nullable','string','max:100'],'address'=>['nullable','string','max:255'],'current_password'=>['required','string'],'password'=>['nullable','string','min:8','max:255','confirmed']]);
        if(!Hash::check($v['current_password'],$a->password))return response()->json(['success'=>false,'message'=>'Current password is incorrect.','errors'=>['current_password'=>['Current password is incorrect.']]],422);
        $a->fill($v);if(!empty($v['password']))$a->password=$v['password'];$a->save();return response()->json(['success'=>true,'message'=>'Profile updated.','data'=>$this->profileData($a)]);
    }
    private function profileData($a):array{return ['id'=>$a->id,'username'=>$a->username,'name'=>$a->name,'email'=>$a->email,'contact'=>$a->contact,'address'=>$a->address];}
}
