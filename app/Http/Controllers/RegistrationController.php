<?php
namespace App\Http\Controllers;
use App\Models\{StudentAccount, Guardian, GradeLevel, AcademicYear};
use App\Services\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function show(string $portal) { return view('portal.registration', ['portal'=>$portal,'years'=>AcademicYear::orderByDesc('id')->get(),'levels'=>GradeLevel::orderBy('id')->get()]); }

    public function store(Request $request, string $portal)
    {
        $table = $portal === 'student' ? 'student_accounts' : 'guardians';
        $data = $request->validate([
            'username'=>['required','alpha_dash','max:100','unique:'.$table.',username'],
            'email'=>['required','email','max:100','unique:'.$table.',email'],
            'password'=>['required','string','min:8','max:255','confirmed'],
            'name'=>['required','string','max:150'], 'contact'=>['nullable','string','max:100'],
            'address'=>['nullable','string','max:255'], 'terms'=>['accepted'], 'privacy'=>['accepted'],
        ] + ($portal === 'student' ? [
            'birthdate'=>['required','date','before:today'], 'gender'=>['required','in:Female,Male'],
            'grlvl_id'=>['required','integer','exists:grlvl,id'], 'acady_id'=>['required','integer','exists:acady,id'],
        ] : []));
        $account = DB::transaction(function () use ($portal, $data) {
            $model = $portal === 'student' ? new StudentAccount : new Guardian;
            $model->fill(array_intersect_key($data,array_flip(['username','email','password','name','contact','address','birthdate','gender'])));
            if ($portal === 'student') $model->fill(['requested_grlvl_id'=>$data['grlvl_id'],'requested_acady_id'=>$data['acady_id']]);
            $model->status = 'PENDING';
            $model->save();
            foreach (['terms','privacy'] as $document) DB::table('agreement_records')->insert(['account_type'=>$portal,'account_id'=>$model->id,'document_type'=>$document,'document_version'=>config('school.'.$document.'_version'),'accepted_at'=>now()]);
            Audit::record($portal,$model->id,'registration.created',$model);
            return $model;
        });
        return redirect()->route('portal.registration.success', ['portal'=>$portal])->with('registration', ['number'=>$account->student?->student_number]);
    }

    public function success(Request $request, string $portal)
    {
        abort_unless($request->session()->has('registration'), 404);
        return view('portal.registration-success',['portal'=>$portal,'registration'=>$request->session()->get('registration')]);
    }
}
