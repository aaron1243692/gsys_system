<?php
namespace App\Http\Controllers;
use App\Models\{AcademicYear,GradeEncodingSchedule};
use App\Services\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB,Gate};
class EncodingScheduleController extends Controller
{
    public function index(Request $request) {
        Gate::forUser($request->user('web'))->authorize('manage-schedules');
        return view('grading.schedule',['years'=>AcademicYear::orderByDesc('id')->get(),'schedules'=>GradeEncodingSchedule::with('academicYear')->orderByDesc('academic_year_id')->orderBy('quarter')->get()]);
    }
    public function store(Request $request) {
        Gate::forUser($request->user('web'))->authorize('manage-schedules');
        $data=$request->validate(['academic_year_id'=>['required','integer','exists:acady,id'],'quarter'=>['required','integer','in:1,2,3'],'opens_at'=>['required','date'],'closes_at'=>['required','date','after:opens_at']]);
        DB::transaction(function() use($request,$data) {
            AcademicYear::whereKey($data['academic_year_id'])->lockForUpdate()->firstOrFail();
            $schedule=GradeEncodingSchedule::firstOrNew(array_intersect_key($data,array_flip(['academic_year_id','quarter'])));
            if(!$schedule->exists) $schedule->created_by=$request->user('web')->id;
            $schedule->fill($data); $schedule->updated_by=$request->user('web')->id; $schedule->save();
            Audit::record('web',$request->user('web')->id,'schedule.saved',$schedule,$data);
        });
        return back()->with('success','Encoding schedule saved.');
    }
}
