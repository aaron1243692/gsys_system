<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AcademicYearController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $academicYears = AcademicYear::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('year_from', 'like', "%{$search}%")
                    ->orWhere('year_to', 'like', "%{$search}%");
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.curiculum.academicyear', [
            'academicYears' => $academicYears,
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('acady', 'name')],
            'year_from' => ['required', 'integer', 'digits:4'],
            'year_to' => ['required', 'integer', 'digits:4', 'gte:year_from'],
        ], [
            'name.unique' => 'This academic year already exists.',
            'year_to.gte' => 'The ending year must be greater than or equal to the starting year.',
        ]);

        AcademicYear::create($validated);

        return redirect()
            ->route('configuration.curriculum.academic-year')
            ->with('success', 'Academic year added successfully.');
    }

    public function update(Request $request, AcademicYear $academicYear): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('acady', 'name')->ignore($academicYear->id),
            ],
            'year_from' => ['required', 'integer', 'digits:4'],
            'year_to' => ['required', 'integer', 'digits:4', 'gte:year_from'],
        ], [
            'name.unique' => 'This academic year already exists.',
            'year_to.gte' => 'The ending year must be greater than or equal to the starting year.',
        ]);

        $academicYear->update($validated);

        return redirect()
            ->route('configuration.curriculum.academic-year')
            ->with('success', 'Academic year updated successfully.');
    }

    public function destroy(AcademicYear $academicYear): RedirectResponse
    {
        $academicYear->delete();

        return redirect()
            ->route('configuration.curriculum.academic-year')
            ->with('success', 'Academic year deleted successfully.');
    }
}
