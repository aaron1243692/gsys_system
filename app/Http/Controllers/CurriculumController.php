<?php

namespace App\Http\Controllers;

use App\Models\Curriculum;
use App\Models\Track;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CurriculumController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $curriculums = Curriculum::query()
            ->with('track')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('track', fn ($query) => $query->where('name', 'like', "%{$search}%"));
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.curiculum.curriculum', [
            'curriculums' => $curriculums,
            'tracks' => Track::query()->orderBy('name')->get(),
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Curriculum::create($this->validateCurriculum($request));

        return redirect()
            ->route('configuration.curriculum.index')
            ->with('success', 'Curriculum added successfully.');
    }

    public function update(Request $request, Curriculum $curriculum): RedirectResponse
    {
        $curriculum->update($this->validateCurriculum($request, $curriculum));

        return redirect()
            ->route('configuration.curriculum.index')
            ->with('success', 'Curriculum updated successfully.');
    }

    public function destroy(Curriculum $curriculum): RedirectResponse
    {
        $curriculum->delete();

        return redirect()
            ->route('configuration.curriculum.index')
            ->with('success', 'Curriculum deleted successfully.');
    }

    private function validateCurriculum(Request $request, ?Curriculum $curriculum = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('curriculum', 'name')->ignore($curriculum?->id),
            ],
            'track_id' => ['nullable', 'integer', 'exists:track,id'],
        ], [
            'name.unique' => 'This curriculum already exists.',
        ]);
    }
}
