<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Curriculum;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BatchController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $curriculumId = $request->query('curriculum_id');

        $batches = Batch::query()
            ->with('curriculum.track')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('year', 'like', "%{$search}%")
                    ->orWhereHas('curriculum', fn ($query) => $query->where('name', 'like', "%{$search}%"));
            })
            ->when($curriculumId, fn ($query) => $query->where('curriculum_id', $curriculumId))
            ->orderByDesc('year')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.curiculum.batch', [
            'batches' => $batches,
            'curriculums' => Curriculum::query()->with('track')->orderBy('name')->get(),
            'search' => $search,
            'curriculumId' => $curriculumId,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Batch::create($this->validateBatch($request));

        return redirect()
            ->route('configuration.curriculum.batch')
            ->with('success', 'Batch added successfully.');
    }

    public function update(Request $request, Batch $batch): RedirectResponse
    {
        $batch->update($this->validateBatch($request, $batch));

        return redirect()
            ->route('configuration.curriculum.batch')
            ->with('success', 'Batch updated successfully.');
    }

    public function destroy(Batch $batch): RedirectResponse
    {
        $batch->delete();

        return redirect()
            ->route('configuration.curriculum.batch')
            ->with('success', 'Batch deleted successfully.');
    }

    private function validateBatch(Request $request, ?Batch $batch = null): array
    {
        return $request->validate([
            'year' => [
                'required',
                'integer',
                'min:1901',
                'max:2155',
                Rule::unique('batch', 'year')->ignore($batch?->id),
            ],
            'curriculum_id' => ['nullable', 'integer', 'exists:curriculum,id'],
        ], [
            'year.unique' => 'This batch year already exists.',
        ]);
    }
}
