<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $teachers = Teacher::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.accounts.teachers', [
            'teachers' => $teachers,
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'username' => ['required', 'string', 'max:255', Rule::unique('teachers', 'username')],
            'email' => ['nullable', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ], [
            'username.unique' => 'This username already exists.',
        ]);

        Teacher::create($validated);

        return redirect()
            ->route('configuration.accounts.teachers')
            ->with('success', 'Teacher added successfully.');
    }

    public function update(Request $request, Teacher $teacher): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'username' => ['required', 'string', 'max:255', Rule::unique('teachers', 'username')->ignore($teacher->id)],
            'email' => ['nullable', 'email', 'max:100'],
        ], [
            'username.unique' => 'This username already exists.',
        ]);

        $teacher->update($validated);

        return redirect()
            ->route('configuration.accounts.teachers')
            ->with('success', 'Teacher updated successfully.');
    }

    public function resetPassword(Request $request, Teacher $teacher): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        $teacher->update([
            'password' => $validated['password'],
        ]);

        return redirect()
            ->route('configuration.accounts.teachers')
            ->with('success', 'Teacher password reset successfully.');
    }

    public function destroy(Teacher $teacher): RedirectResponse
    {
        $teacher->delete();

        return redirect()
            ->route('configuration.accounts.teachers')
            ->with('success', 'Teacher deleted successfully.');
    }
}
