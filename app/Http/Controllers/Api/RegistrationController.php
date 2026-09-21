<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\{AcademicYear,GradeLevel};
use App\Services\RegistrationService;
use Illuminate\Http\{JsonResponse,Request};
class RegistrationController extends Controller
{
    public function options():JsonResponse{return response()->json(['success'=>true,'data'=>['school_years'=>AcademicYear::orderByDesc('id')->get(['id','name']),'grade_levels'=>GradeLevel::orderBy('id')->get(['id','name'])]]);}
    public function student(Request $r):JsonResponse{return $this->store($r,'student');}
    public function guardian(Request $r):JsonResponse{return $this->store($r,'guardian');}
    private function store(Request $r,string $role):JsonResponse
    {
        $service=app(RegistrationService::class);
        $account=$service->register($role,$r->validate($service->rules($role), $service->messages()));
        return response()->json(['success'=>true,'message'=>'Registration submitted successfully. Your account is waiting for approval.','data'=>array_filter(['id'=>$account->id,'student_number'=>$account->student?->student_number,'status'=>$account->status])],201);
    }
}
