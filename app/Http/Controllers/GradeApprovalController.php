<?php
namespace App\Http\Controllers;
use App\Models\GradeSheet;
use App\Services\{Audit,GradeWorkflow};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB,Gate};
class GradeApprovalController extends Controller
{
    public function index(Request $request) {
        Gate::forUser($request->user('web'))->authorize('approve-grades');
        $filters=$request->validate(['quarter'=>['nullable','integer','in:1,2,3'],'status'=>['nullable','in:DRAFT,SUBMITTED,RETURNED,APPROVED'],'academic_year_id'=>['nullable','integer'],'grade_level_id'=>['nullable','integer'],'class_id'=>['nullable','integer'],'subject_id'=>['nullable','integer'],'teacher_id'=>['nullable','integer']]);
        $query=GradeSheet::query(); foreach($filters as $field=>$value) if($value!==null) $query->where($field,$value);
        $options=[]; foreach(['academic_year','grade_level','class','subject','teacher'] as $field) $options[$field]=GradeSheet::select($field.'_id',$field.'_name')->distinct()->get();
        return view('report.grades.aproval',['sheets'=>$query->latest()->paginate(20)->withQueryString(),'options'=>$options]);
    }
    public function show(Request $request,GradeSheet $sheet) {
        Gate::forUser($request->user('web'))->authorize('approve-grades');
        return view('report.grades.review',['sheet'=>$sheet->load(['grades','approvedBy','returnedBy']),'audit'=>DB::table('audit_events')->where('target_type','grade_sheets')->where('target_id',$sheet->id)->orderByDesc('id')->get()]);
    }
    public function update(Request $request,GradeSheet $sheet,GradeWorkflow $workflow) {
        Gate::forUser($request->user('web'))->authorize('approve-grades');
        $data=$request->validate(['action'=>['required','in:approve,return'],'reason'=>['required_if:action,return','nullable','string','max:2000'],'correction_until'=>['required_if:action,return','nullable','date','after:now']]);
        DB::transaction(function() use($request,$sheet,$workflow,$data) {
            $sheet=GradeSheet::whereKey($sheet->id)->lockForUpdate()->firstOrFail();
            abort_unless($sheet->status==='SUBMITTED',409,'Only a submitted sheet can be reviewed.');
            if($data['action']==='approve') {
                $workflow->assertComplete($sheet);
                $sheet->fill(['status'=>'APPROVED','approved_by'=>$request->user('web')->id,'approved_at'=>now()]);
            } else $sheet->fill(['status'=>'RETURNED','returned_by'=>$request->user('web')->id,'returned_at'=>now(),'return_reason'=>$data['reason'],'correction_until'=>$data['correction_until']]);
            $sheet->save(); Audit::record('web',$request->user('web')->id,'sheet.'.strtolower($sheet->status),$sheet,$data);
        });
        return back()->with('success',$data['action']==='approve' ? 'Grade sheet approved successfully.' : 'Grade sheet returned for correction.');
    }
}
