<?php

namespace App\Http\Controllers;

use App\Models\GradeLevel;
use App\Models\Track;
use App\Models\TrackSubject;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TrackController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $tracks = Track::query()
            ->with(['trackSubjects.gradeLevel', 'trackSubjects.subject.teacher'])
            ->when($search !== '', fn ($query) => $query->where('name', 'like', "%{$search}%"))
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('configuration.curiculum.track', [
            'tracks' => $tracks,
            'gradeLevels' => GradeLevel::query()->orderBy('name')->get(),
            'subjects' => Subject::query()->with(['category', 'teacher'])->orderBy('name')->get(),
            'search' => $search,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Track::create($this->validateTrack($request));

        return redirect()
            ->route('configuration.curriculum.tracks')
            ->with('success', 'Track added successfully.');
    }

    public function update(Request $request, Track $track): RedirectResponse
    {
        $track->update($this->validateTrack($request, $track));

        return redirect()
            ->route('configuration.curriculum.tracks')
            ->with('success', 'Track updated successfully.');
    }

    public function destroy(Track $track): RedirectResponse
    {
        $track->delete();

        return redirect()
            ->route('configuration.curriculum.tracks')
            ->with('success', 'Track deleted successfully.');
    }

    public function storeSubject(Request $request, Track $track): RedirectResponse
    {
        $validated = $request->validate([
            'subject_ids' => ['nullable', 'array'],
            'subject_ids.*' => ['integer', 'distinct', 'exists:subject,id'],
            'subject_grlvl_ids' => ['nullable', 'array'],
            'subject_grlvl_ids.*' => ['nullable', 'integer', 'exists:grlvl,id'],
        ]);

        $subjectIds = collect($validated['subject_ids'] ?? [])
            ->map(fn ($subjectId) => (int) $subjectId)
            ->unique()
            ->values();

        $gradeLevelIds = collect($validated['subject_grlvl_ids'] ?? []);

        DB::transaction(function () use ($track, $subjectIds, $gradeLevelIds): void {
            TrackSubject::where('track_id', $track->id)->delete();

            $subjectIds->each(fn (int $subjectId) => TrackSubject::create([
                'track_id' => $track->id,
                'grlvl_id' => $gradeLevelIds->get((string) $subjectId) ?: null,
                'subject_id' => $subjectId,
            ]));
        });

        return redirect()
            ->route('configuration.curriculum.tracks')
            ->with('success', 'Track subjects saved successfully.');
    }

    public function destroySubject(TrackSubject $trackSubject): RedirectResponse
    {
        $trackSubject->delete();

        return redirect()
            ->route('configuration.curriculum.tracks')
            ->with('success', 'Subject removed from track successfully.');
    }

    private function validateTrack(Request $request, ?Track $track = null): array
    {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('track', 'name')->ignore($track?->id),
            ],
        ], [
            'name.unique' => 'This track already exists.',
        ]);
    }
}
