<?php
namespace App\Http\Controllers;
use App\Models\{Student, Guardian, GuardianChild, GradeLevel, AcademicYear};
use App\Services\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth};
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function show(string $portal) { return view('portal.registration', ['portal'=>$portal,'years'=>AcademicYear::orderByDesc('id')->get(),'levels'=>GradeLevel::orderBy('id')->get()]); }

    public function store(Request $request, string $portal)
    {
        $table = $portal === 'student' ? 'students' : 'guardians';
        $data = $request->validate([
            'username'=>['required','alpha_dash','max:100','unique:'.$table.',username'],
            'email'=>['required','email','max:100','unique:'.$table.',email'],
            'password'=>['required','string','min:8','max:255','confirmed'],
            'name'=>['required','string','max:150'], 'contact'=>['nullable','string','max:100'],
            'address'=>['nullable','string','max:255'], 'terms'=>['accepted'], 'privacy'=>['accepted'],
        ] + ($portal === 'student' ? [
            'birthdate'=>['required','date','before:today'], 'gender'=>['required','in:Female,Male'],
            'grlvl_id'=>['required','integer','exists:grlvl,id'], 'acady_id'=>['required','integer','exists:acady,id'],
        ] : $this->claimRules()));
        // Unique database index is the final arbiter. Retry only number collisions.
        for ($attempt=0; $attempt<5; $attempt++) {
            try {
                $account = DB::transaction(function () use ($portal, $data) {
                    $model = $portal === 'student' ? new Student : new Guardian;
                    $model->fill(array_intersect_key($data,array_flip(['username','email','password'])));
                    $model->status = 'PENDING';
                    if ($portal === 'guardian') $model->fill(array_intersect_key($data,array_flip(['name','contact','address'])));
                    $model->save();
                    if ($portal === 'student') $model->info()->create(array_intersect_key($data,array_flip(['name','contact','address','birthdate','gender','grlvl_id','acady_id'])) + ['admited'=>0]);
                    else $this->claim($model, $data);
                    foreach (['terms','privacy'] as $document) DB::table('agreement_records')->insert(['account_type'=>$portal,'account_id'=>$model->id,'document_type'=>$document,'document_version'=>config('school.'.$document.'_version'),'accepted_at'=>now()]);
                    Audit::record($portal,$model->id,'registration.created',$model);
                    return $model;
                });
                return redirect()->route('portal.registration.success', ['portal'=>$portal])->with('registration', ['number'=>$account->student_number]);
            } catch (\Illuminate\Database\QueryException $e) {
                if (!str_contains($e->getMessage(), 'student_number') || $attempt === 4) throw $e;
            }
        }
    }

    public function success(Request $request, string $portal)
    {
        abort_unless($request->session()->has('registration'), 404);
        return view('portal.registration-success',['portal'=>$portal,'registration'=>$request->session()->get('registration')]);
    }
    private function claimRules(): array { return ['student_number'=>['required','digits:11'],'student_name'=>['required','string','max:150'],'student_birthdate'=>['required','date'],'relationship'=>['required','string','max:100']]; }
    private function claim(Guardian $guardian, array $data): void
    {
        $student = Student::where('student_number',$data['student_number'])->whereHas('info',fn($q)=>$q->where('name',$data['student_name'])->whereDate('birthdate',$data['student_birthdate']))->first();
        if (!$student) throw ValidationException::withMessages(['student_number'=>'The supplied student details could not be matched. Contact the school for assistance.']);
        if (GuardianChild::where('guardian_id',$guardian->id)->where('student_id',$student->id)->exists()) throw ValidationException::withMessages(['student_number'=>'A relationship request already exists. Contact staff to review it.']);
        $link = new GuardianChild(['guardian_id'=>$guardian->id,'student_id'=>$student->id]);
        $link->forceFill(['status'=>'PENDING','relationship'=>$data['relationship'],'claimed_student_name'=>$data['student_name'],'claimed_birthdate'=>$data['student_birthdate']])->save();
        Audit::record('guardian',$guardian->id,'child.requested',$link);
    }
    public function link(Request $request)
    {
        $data = $request->validate($this->claimRules());
        DB::transaction(function () use ($data) {
            $guardian = Guardian::whereKey(Auth::guard('guardian')->id())->lockForUpdate()->firstOrFail();
            $this->claim($guardian,$data);
        });
        return back()->with('success','Child link requested. Staff verification is required before access.');
    }
}
