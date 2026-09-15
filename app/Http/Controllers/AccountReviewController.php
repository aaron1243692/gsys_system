<?php
namespace App\Http\Controllers;
use App\Models\{Student, Guardian, GuardianChild};
use App\Services\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Gate};
class AccountReviewController extends Controller
{
    private function model(string $type) { abort_unless(in_array($type,['student','guardian']),404); return $type === 'student' ? new Student : new Guardian; }
    public function index(Request $request)
    {
        Gate::forUser($request->user('web'))->authorize('manage-registrations');
        $data=$request->validate(['type'=>['nullable','in:student,guardian'],'status'=>['nullable','in:PENDING,ACTIVE,REJECTED,DEACTIVATED'],'search'=>['nullable','string','max:150'],'date'=>['nullable','date']]);
        $type=$data['type']??'student'; $status=$data['status']??'PENDING';
        $accounts=$this->model($type)->newQuery()->where('status',$status)
            ->when($data['date']??null,fn($q,$v)=>$q->whereDate('created_at',$v))
            ->when($data['search']??null,function($q,$v) use ($type) { $q->where(function($q) use ($v,$type) {
                $q->where('username','like',"%$v%")->orWhere('email','like',"%$v%");
                if($type==='student') $q->orWhere('student_number','like',"%$v%")->orWhereHas('info',fn($q)=>$q->where('name','like',"%$v%"));
                else $q->orWhere('name','like',"%$v%");
            }); })->latest()->paginate(20)->withQueryString();
        return view('configuration.accounts.registrations',compact('accounts','type','status'));
    }
    public function show(Request $request,string $type,int $id)
    {
        Gate::forUser($request->user('web'))->authorize('manage-registrations');
        $account=$this->model($type)->findOrFail($id);
        $links=$type==='guardian' ? $account->children()->with('student.info')->get() : collect();
        $audit=DB::table('audit_events')->where('target_type',$account->getTable())->where('target_id',$id)->orderByDesc('id')->get();
        return view('configuration.accounts.registration-review',compact('account','type','links','audit'));
    }
    public function update(Request $request,string $type,int $id)
    {
        Gate::forUser($request->user('web'))->authorize('manage-registrations');
        $data=$request->validate(['action'=>['required','in:activate,reject,deactivate'],'reason'=>['required_if:action,reject','nullable','string','max:2000']]);
        DB::transaction(function() use($request,$type,$id,$data) {
            $account=$this->model($type)->newQuery()->whereKey($id)->lockForUpdate()->firstOrFail();
            $action=$data['action'];
            if($action==='activate' && $type==='guardian') abort_unless($account->children()->where('status','VERIFIED')->exists(),422,'Verify at least one child relationship before activation.');
            $status=match($action){'activate'=>'ACTIVE','reject'=>'REJECTED','deactivate'=>'DEACTIVATED'};
            abort_if($account->status===$status,409,'Account already has this status.');
            $prefix=match($action){'activate'=>'activated','reject'=>'rejected','deactivate'=>'deactivated'};
            $account->forceFill(['status'=>$status,$prefix.'_by'=>$request->user('web')->id,$prefix.'_at'=>now()] + ($action==='reject'?['rejection_reason'=>$data['reason']]:[]))->save();
            Audit::record('web',$request->user('web')->id,'account.'.$prefix,$account,['reason'=>$data['reason']??null]);
        });
        return back()->with('success','Account status updated.');
    }
    public function verify(Request $request,GuardianChild $link)
    {
        Gate::forUser($request->user('web'))->authorize('manage-registrations');
        $data=$request->validate(['status'=>['required','in:VERIFIED,REJECTED'],'verification_note'=>['required','string','max:2000']]);
        DB::transaction(function() use($request,$link,$data) {
            $link=GuardianChild::whereKey($link->id)->lockForUpdate()->firstOrFail();
            abort_unless($link->student()->exists() && $link->guardian()->exists(),422,'The linked account is missing.');
            $link->forceFill($data+['verified_by'=>$request->user('web')->id,'verified_at'=>now()])->save();
            Audit::record('web',$request->user('web')->id,'child.'.strtolower($data['status']),$link,['note'=>$data['verification_note']]);
        });
        return back()->with('success','Relationship review saved.');
    }
}
