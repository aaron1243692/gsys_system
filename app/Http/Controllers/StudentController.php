<?php

namespace App\Http\Controllers;

use App\Models\Student;
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

        $students = Student::query()
            ->with('info')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('info', fn ($query) => $query->where('name', 'like', "%{$search}%"));
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.accounts.students', [
            'students' => $students,
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'username' => ['required', 'string', 'max:255', Rule::unique('students', 'username')],
            'email' => ['nullable', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ], [
            'username.unique' => 'This username already exists.',
        ]);

        DB::transaction(function () use ($validated) {
            $student = Student::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            $student->info()->create([
                'name' => $validated['name'],
            ]);
        });

        return redirect()
            ->route('configuration.accounts.students')
            ->with('success', 'Student added successfully.');
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'username' => ['required', 'string', 'max:255', Rule::unique('students', 'username')->ignore($student->id)],
            'email' => ['nullable', 'email', 'max:100'],
        ], [
            'username.unique' => 'This username already exists.',
        ]);

        DB::transaction(function () use ($student, $validated) {
            $studentData = [
                'username' => $validated['username'],
                'email' => $validated['email'],
            ];

            $student->update($studentData);

            $student->info()->updateOrCreate(
                ['student_id' => $student->id],
                ['name' => $validated['name']]
            );
        });

        return redirect()
            ->route('configuration.accounts.students')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()
            ->route('configuration.accounts.students')
            ->with('success', 'Student deleted successfully.');
    }

    public function resetPassword(Request $request, Student $student): RedirectResponse
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
