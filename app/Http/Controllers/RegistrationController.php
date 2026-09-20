<?php
namespace App\Http\Controllers;
use App\Models\{GradeLevel, AcademicYear};
use App\Services\RegistrationService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function show(string $portal) { return view('portal.registration', ['portal'=>$portal,'years'=>AcademicYear::orderByDesc('id')->get(),'levels'=>GradeLevel::orderBy('id')->get()]); }

    public function store(Request $request, string $portal, RegistrationService $service)
    {
        $data = $request->validate($service->rules($portal));
        try {
            $account = $service->register($portal, $data);
        } catch (\Throwable $exception) {
            report($exception);
            return redirect()->route('portal.register', ['portal' => $portal])
                ->withInput($request->only(array_diff(array_keys($service->rules($portal)), ['password'])))
                ->withErrors(['registration' => 'Registration could not be completed. Please try again.']);
        }

        return redirect()->route('portal.login', ['portal' => $portal])
            ->with('success', 'Registration submitted successfully. Your account is waiting for approval by the school. You can sign in after your account has been activated.')
            ->with('registration', ['portal' => $portal, 'number' => $account->student?->student_number]);
    }

    public function success(Request $request, string $portal)
    {
        abort_unless($request->session()->has('registration'), 404);
        return view('portal.registration-success',['portal'=>$portal,'registration'=>$request->session()->get('registration')]);
    }
}
