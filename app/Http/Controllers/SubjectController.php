<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectCategory;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SubjectController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $categoryId = $request->query('subcat_id');

        $subjects = Subject::query()
            ->with(['category', 'teacher'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhereHas('teacher', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('username', 'like', "%{$search}%");
                        });
                });
            })
            ->when($categoryId, fn ($query) => $query->where('subcat_id', $categoryId))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.curiculum.subject', [
            'subjects' => $subjects,
            'categories' => SubjectCategory::query()->orderBy('name')->get(),
            'teachers' => Teacher::query()->orderBy('name')->get(),
            'search' => $search,
            'categoryId' => $categoryId,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSubject($request);

        Subject::create($validated);

        return redirect()
            ->route('configuration.curriculum.subjects')
            ->with('success', 'Subject added successfully.');
    }

    public function update(Request $request, Subject $subject): RedirectResponse
    {
        $validated = $this->validateSubject($request, $subject);

        $subject->update($validated);

        return redirect()
            ->route('configuration.curriculum.subjects')
            ->with('success', 'Subject updated successfully.');
    }

    public function destroy(int $subject): RedirectResponse
    {
        $subject = Subject::withTrashed()->findOrFail($subject);
        $subject->forceDelete();

        return redirect()
            ->route('configuration.curriculum.subjects')
            ->with('success', 'Subject deleted permanently.');
    }

    private function validateSubject(Request $request, ?Subject $subject = null): array
    {
        return $request->validate([
            'subcat_id' => ['nullable', 'integer', 'exists:subcat,id'],
            'teacher_id' => ['nullable', 'integer', 'exists:teachers,id'],
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('subject', 'name')
                    ->where('subcat_id', $request->input('subcat_id'))
                    ->whereNull('deleted_at')
                    ->ignore($subject?->id),
            ],
            'code' => ['nullable', 'string', 'max:50'],
        ], [
            'name.unique' => 'This subject already exists for the selected category.',
        ]);
    }
}
