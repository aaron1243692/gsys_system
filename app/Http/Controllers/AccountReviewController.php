<?php
namespace App\Http\Controllers;
use App\Models\{Student, StudentAccount, Guardian};
use App\Services\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
class AccountReviewController extends Controller
{
    private function model(string $type) { abort_unless(in_array($type,['student','guardian']),404); return $type === 'student' ? new StudentAccount : new Guardian; }
    public function index(Request $request)
    {
        $data=$request->validate(['type'=>['nullable','in:student,guardian'],'status'=>['nullable','in:PENDING,ACTIVE,REJECTED,DEACTIVATED'],'search'=>['nullable','string','max:150'],'date'=>['nullable','date']]);
        $type=$data['type']??'student'; $status=$data['status']??'PENDING';
        $accounts=$this->model($type)->newQuery()
            ->when($type === 'student', fn($q) => $q->with('student'))
            ->where('status',$status)
            ->when($data['date']??null,fn($q,$v)=>$q->whereDate('created_at',$v))
            ->when($data['search']??null,function($q,$v) use ($type) { $q->where(function($q) use ($v,$type) {
                $q->where('username','like',"%$v%")->orWhere('email','like',"%$v%");
                if($type==='student') $q->orWhere('name','like',"%$v%")
                    ->orWhereHas('student',fn($q)=>$q->where('student_number','like',"%$v%"));
                else $q->orWhere('name','like',"%$v%");
            }); })->latest()->paginate(20)->withQueryString();
        return view('configuration.accounts.registrations',compact('accounts','type','status'));
    }
    public function show(Request $request,string $type,int $id)
    {
        $account=$this->model($type)->findOrFail($id);
        $links=$type==='guardian' ? $account->children()->where('status', 'VERIFIED')->with('student.info')->get() : collect();
        $records = collect(); $selectedStudent = null;
        if ($type === 'student') {
            $search = trim((string) $request->query('record_search', ''));
            if ($search !== '') {
                $records = Student::with(['info.gradeLevel', 'info.schoolClass', 'info.academicYear', 'portalAccount'])
                    ->where(fn ($query) => $query->where('student_number', 'like', "%{$search}%")
                        ->orWhereHas('info', fn ($info) => $info->where('name', 'like', "%{$search}%")
                            ->orWhereHas('gradeLevel', fn ($level) => $level->where('name', 'like', "%{$search}%"))
                            ->orWhereHas('schoolClass', fn ($class) => $class->where('name', 'like', "%{$search}%"))
                            ->orWhereHas('academicYear', fn ($year) => $year->where('name', 'like', "%{$search}%"))))
                    ->orderBy('id')->limit(30)->get();
            }
            if ($request->filled('record_id')) $selectedStudent = Student::with(['info.gradeLevel','info.schoolClass','info.academicYear','portalAccount'])->findOrFail($request->integer('record_id'));
            $account->load('student.info.gradeLevel', 'student.info.schoolClass', 'student.info.academicYear');
        }
        $audit=DB::table('audit_events')->where('target_type',$account->getTable())->where('target_id',$id)->orderByDesc('id')->get();
        return view('configuration.accounts.registration-review',compact('account','type','links','audit','records','selectedStudent'));
    }
    public function update(Request $request,string $type,int $id)
    {
        $data=$request->validate(['action'=>['required','in:activate,reject,deactivate'],'reason'=>['required_if:action,reject','nullable','string','max:2000']]);
        abort_unless($request->user('web')->can('registrations.'.$data['action']), 403);
        DB::transaction(function() use($request,$type,$id,$data) {
            $account=$this->model($type)->newQuery()->whereKey($id)->lockForUpdate()->firstOrFail();
            $action=$data['action'];
            if($action==='activate' && $type==='student') {
                $info = $account->student?->info;
                if (! $info || ! $info->admited || ! $info->class_id || ! $info->grlvl_id || ! $info->acady_id
                    || ! $info->schoolClass()->where('grlvl_id', $info->grlvl_id)->where('acady_id', $info->acady_id)->exists())
                    throw ValidationException::withMessages(['action' => "Approve the student's pre-registration and complete the academic placement before activation."]);
            }
            $status=match($action){'activate'=>'ACTIVE','reject'=>'REJECTED','deactivate'=>'DEACTIVATED'};
            abort_if($account->status===$status,409,'Account already has this status.');
            $prefix=match($action){'activate'=>'activated','reject'=>'rejected','deactivate'=>'deactivated'};
            $account->forceFill(['status'=>$status,$prefix.'_by'=>$request->user('web')->id,$prefix.'_at'=>now()] + ($action==='reject'?['rejection_reason'=>$data['reason']]:[]))->save();
            if ($type === 'student' && $account->student) {
                $account->student->forceFill(['status' => $status, $prefix.'_by' => $request->user('web')->id, $prefix.'_at' => now()])->save();
            }
            Audit::record('web',$request->user('web')->id,'account.'.$prefix,$account,['reason'=>$data['reason']??null]);
        });
        return back()->with('success','Account status updated.');
    }
    public function linkStudent(Request $request, StudentAccount $account)
    {
        $data = $request->validate(['student_id' => ['required','integer','exists:students,id'], 'confirm' => ['required','accepted']]);
        DB::transaction(function () use ($request, $account, $data) {
            $account = StudentAccount::whereKey($account->id)->lockForUpdate()->firstOrFail();
            $student = Student::whereKey($data['student_id'])->lockForUpdate()->firstOrFail();
            $info = $student->info()->first();
            if (! $info || ! $info->admited || ! $info->class_id || ! $info->grlvl_id || ! $info->acady_id
                || ! $info->schoolClass()->where('grlvl_id', $info->grlvl_id)->where('acady_id', $info->acady_id)->exists())
                throw ValidationException::withMessages(['student_id' => 'Complete the academic enrollment, class, grade level, and school year before linking.']);
            if (StudentAccount::where('student_id', $student->id)->whereKeyNot($account->id)->exists())
                throw ValidationException::withMessages(['student_id' => 'This academic student already has a portal account.']);
            if ($account->student_id && (int) $account->student_id !== (int) $student->id)
                throw ValidationException::withMessages(['student_id' => 'This account is already linked to another academic student.']);
            $account->student_id = $student->id;
            $account->status = 'ACTIVE';
            $account->activated_by = $request->user('web')->id;
            $account->activated_at = now();
            $account->save();
            $student->forceFill(['status' => 'ACTIVE', 'activated_by' => $request->user('web')->id, 'activated_at' => now()])->save();
            Audit::record('web', $request->user('web')->id, 'student.linked_activated', $account, ['student_id' => $student->id]);
        });
        return redirect()->route('configuration.accounts.registrations.show', ['type' => 'student', 'id' => $account->id])->with('success', 'Academic student linked and account activated.');
    }
}
