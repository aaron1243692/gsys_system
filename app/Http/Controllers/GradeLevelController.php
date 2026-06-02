<?php

namespace App\Http\Controllers;

use App\Models\GradeLevel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GradeLevelController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $gradeLevels = GradeLevel::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.curiculum.gardelevel', [
            'gradeLevels' => $gradeLevels,
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('grlvl', 'name')],
        ], [
            'name.unique' => 'This grade level already exists.',
        ]);

        GradeLevel::create($validated);

        return redirect()
            ->route('configuration.curriculum.grade-level')
            ->with('success', 'Grade level added successfully.');
    }

    public function update(Request $request, GradeLevel $gradeLevel): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('grlvl', 'name')->ignore($gradeLevel->id),
            ],
        ], [
            'name.unique' => 'This grade level already exists.',
        ]);

        $gradeLevel->update($validated);

        return redirect()
            ->route('configuration.curriculum.grade-level')
            ->with('success', 'Grade level updated successfully.');
    }

    public function destroy(GradeLevel $gradeLevel): RedirectResponse
    {
        $gradeLevel->delete();

        return redirect()
            ->route('configuration.curriculum.grade-level')
            ->with('success', 'Grade level deleted successfully.');
    }
}
