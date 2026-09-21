<?php

namespace App\Http\Controllers;

use App\Models\StudentAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $link = $request->query('link');
        $status = $request->query('status');
        $students = StudentAccount::query()
            ->with('student.info.gradeLevel', 'student.info.schoolClass', 'student.info.academicYear')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('student.info', fn ($info) => $info->where('lrn', 'like', "%{$search}%"))
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhereHas('student', fn ($query) => $query->where('student_number', 'like', "%{$search}%")
                            ->orWhereHas('info', fn ($info) => $info->where('name', 'like', "%{$search}%")));
                });
            })
            ->when($link === 'linked', fn($query) => $query->whereNotNull('student_id'))
            ->when($link === 'unlinked', fn($query) => $query->whereNull('student_id'))
            ->when(in_array($status, ['PENDING','ACTIVE','REJECTED','DEACTIVATED'], true), fn($query) => $query->where('status', $status))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.accounts.students', [
            'students' => $students,
            'search' => $search,
            'link' => $link,
            'status' => $status,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'username' => ['required', 'string', 'max:255', Rule::unique('student_accounts', 'username')],
            'email' => ['nullable', 'email', 'max:100', Rule::unique('student_accounts', 'email')],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ], [
            'username.unique' => 'This username already exists.',
        ]);

        DB::transaction(function () use ($validated) {
            StudentAccount::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ])->forceFill(['status' => 'PENDING'])->save();
        });

        return redirect()
            ->route('configuration.accounts.students')
            ->with('success', 'Student added successfully.');
    }

    public function update(Request $request, StudentAccount $student): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'username' => ['required', 'string', 'max:255', Rule::unique('student_accounts', 'username')->ignore($student->id)],
            'email' => ['nullable', 'email', 'max:100', Rule::unique('student_accounts', 'email')->ignore($student->id)],
        ], [
            'username.unique' => 'This username already exists.',
        ]);

        DB::transaction(function () use ($student, $validated) {
            $student->update([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
            ]);
        });

        return redirect()
            ->route('configuration.accounts.students')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(StudentAccount $student): RedirectResponse
    {
        $student->forceFill(['status' => 'DEACTIVATED', 'deactivated_by' => auth()->id(), 'deactivated_at' => now()])->save();

        return redirect()
            ->route('configuration.accounts.students')
            ->with('success', 'Student portal account deactivated successfully.');
    }

    public function resetPassword(Request $request, StudentAccount $student): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        $student->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('configuration.accounts.students')
            ->with('success', 'Student password reset successfully.');
    }
}
