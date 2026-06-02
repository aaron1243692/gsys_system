<?php

namespace App\Http\Controllers;

use App\Models\SubjectCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SubjectCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $categories = SubjectCategory::query()
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.curiculum.subjectcategory', [
            'categories' => $categories,
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('subcat', 'name')],
        ], [
            'name.unique' => 'This subject category already exists.',
        ]);

        SubjectCategory::create($validated);

        return redirect()
            ->route('configuration.curriculum.subject-category')
            ->with('success', 'Subject category added successfully.');
    }

    public function update(Request $request, SubjectCategory $subjectCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('subcat', 'name')->ignore($subjectCategory->id),
            ],
        ], [
            'name.unique' => 'This subject category already exists.',
        ]);

        $subjectCategory->update($validated);

        return redirect()
            ->route('configuration.curriculum.subject-category')
            ->with('success', 'Subject category updated successfully.');
    }

    public function destroy(SubjectCategory $subjectCategory): RedirectResponse
    {
        $subjectCategory->delete();

        return redirect()
            ->route('configuration.curriculum.subject-category')
            ->with('success', 'Subject category deleted successfully.');
    }
}
