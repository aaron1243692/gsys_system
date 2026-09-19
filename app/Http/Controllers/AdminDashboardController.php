<?php
namespace App\Http\Controllers;
use App\Services\AdminDashboardData;
use Illuminate\Http\Request;
class AdminDashboardController extends Controller
{
    public function __invoke(Request $request,AdminDashboardData $dashboard)
    {
        $validated=$request->validate(['school_year_id'=>['nullable','integer','exists:acady,id']]);
        return view('dashboard',$dashboard->build(isset($validated['school_year_id'])?(int)$validated['school_year_id']:null));
    }
}
