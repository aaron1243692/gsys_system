<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\{AcademicYear,GradeLevel,Guardian,StudentAccount};
use Illuminate\Http\{JsonResponse,Request};
use Illuminate\Support\Facades\DB;
class RegistrationController extends Controller
{
    public function options():JsonResponse{return response()->json(['success'=>true,'data'=>['school_years'=>AcademicYear::orderByDesc('id')->get(['id','name']),'grade_levels'=>GradeLevel::orderBy('id')->get(['id','name'])]]);}
    public function student(Request $r):JsonResponse{return $this->store($r,'student');}
    public function guardian(Request $r):JsonResponse{return $this->store($r,'guardian');}
    private function store(Request $r,string $role):JsonResponse
    {
        $table=$role==='student'?'student_accounts':'guardians';$v=$r->validate(['username'=>['required','alpha_dash','max:100','unique:'.$table.',username'],'email'=>['required','email','max:100','unique:'.$table.',email'],'password'=>['required','string','min:8','max:255','confirmed'],'name'=>['required','string','max:150'],'contact'=>['nullable','string','max:100'],'address'=>['nullable','string','max:255'],'terms'=>['accepted'],'privacy'=>['accepted']]+($role==='student'?['birthdate'=>['required','date','before:today'],'gender'=>['required','in:Female,Male'],'grlvl_id'=>['required','integer','exists:grlvl,id'],'acady_id'=>['required','integer','exists:acady,id']]:[]));
        $account=DB::transaction(function()use($role,$v){$m=$role==='student'?new StudentAccount:new Guardian;$m->fill(array_intersect_key($v,array_flip(['username','email','password','name','contact','address','birthdate','gender'])));if($role==='student')$m->fill(['requested_grlvl_id'=>$v['grlvl_id'],'requested_acady_id'=>$v['acady_id']]);$m->status='PENDING';$m->save();foreach(['terms','privacy']as$doc)DB::table('agreement_records')->insert(['account_type'=>$role,'account_id'=>$m->id,'document_type'=>$doc,'document_version'=>config('school.'.$doc.'_version'),'accepted_at'=>now()]);return $m;});
        return response()->json(['success'=>true,'message'=>'Registration submitted for staff review.','data'=>['id'=>$account->id,'status'=>$account->status]],201);
    }
}
