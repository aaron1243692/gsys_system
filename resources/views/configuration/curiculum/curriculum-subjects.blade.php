@extends('layouts.app')

@section('title', 'Curriculum Subjects')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Configuration</p>
            <h1 class="text-3xl font-black text-slate-950">Curriculum Subjects</h1>
        </section>

        @if (session('success') || $errors->any())
            @php
                $isSuccess = session('success') !== null;
                $feedbackTitle = $isSuccess ? 'Success!' : 'Failed!';
                $feedbackMessage = session('success') ?? $errors->first();
                $feedbackColor = $isSuccess ? 'blue' : 'red';
            @endphp

            <div id="curriculum-subject-feedback-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-5 backdrop-blur-sm">
                <div class="w-full max-w-sm rounded-lg border border-slate-200 bg-white p-4 text-center text-slate-950 shadow-2xl">
                    <div class="relative">
                        <h2 class="text-xl font-black {{ $feedbackColor === 'blue' ? 'text-blue-700' : 'text-red-600' }}">{{ $feedbackTitle }}</h2>
                        <button type="button" onclick="document.getElementById('curriculum-subject-feedback-modal').remove()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                            &times;
                        </button>
                    </div>

                    <p class="mx-auto mt-3 max-w-xs text-center text-sm leading-6 text-slate-600">{{ $feedbackMessage }}</p>

                    <button type="button" onclick="document.getElementById('curriculum-subject-feedback-modal').remove()" class="mt-4 w-full rounded-[2rem] {{ $feedbackColor === 'blue' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-bold text-white transition hover:scale-105">
                        OK
                    </button>
                </div>
            </div>
        @endif

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                    <form method="GET" action="{{ route('configuration.curriculum.subject-map') }}" class="w-full md:max-w-md">
                        <label class="block text-sm font-bold text-slate-800" for="curriculum-id">Curriculum</label>
                        <select id="curriculum-id" name="curriculum_id" onchange="this.form.submit()" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            @foreach ($curriculums as $curriculum)
                                <option value="{{ $curriculum->id }}" @selected($selectedCurriculum?->id === $curriculum->id)>
                                    {{ $curriculum->name }}{{ $curriculum->track ? ' - '.$curriculum->track->name : '' }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    @if ($selectedCurriculum)
                        <div class="rounded-lg border border-blue-100 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-800">
                            {{ $selectedCurriculum->name }}
                        </div>
                    @endif
                </div>

                @if (! $selectedCurriculum)
                    <div class="flex flex-1 items-center justify-center rounded-lg border border-slate-200 p-8 text-center text-sm font-semibold text-slate-500">
                        Add a curriculum first.
                    </div>
                @else
                    <div class="flex flex-1 flex-col gap-4 overflow-y-auto">
                        @foreach ($gradeLevels as $gradeLevel)
                            @php
                                $normalizedGradeLevelValue = is_array($gradeLevel) ? $gradeLevel['value'] : (int) $gradeLevel;
                                $normalizedGradeLevelName = is_array($gradeLevel) ? $gradeLevel['name'] : 'Grade '.$normalizedGradeLevelValue;
                            @endphp

                            <section class="rounded-lg border border-slate-200 bg-slate-50 p-3">
                                <div class="mb-3 flex items-center justify-between gap-3">
                                    <div>
                                        <h2 class="text-xl font-black text-slate-950">{{ $normalizedGradeLevelName }}</h2>
                                        <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-500">Senior High School grade level</p>
                                    </div>
                                </div>

                                <div class="grid gap-3 lg:grid-cols-2">
                            @foreach ($semesters as $semester)
                                @php
                                    $gradeLevelValue = $normalizedGradeLevelValue;
                                    $key = "{$gradeLevelValue}-{$semester}";
                                    $assigned = collect($curriculumSubjects->get($key, collect()));
                                    $assignedIds = $assigned->pluck('subject_id')->map(fn ($id) => (int) $id)->all();
                                @endphp

                                <form method="POST" action="{{ route('configuration.curriculum.subject-map.store', $selectedCurriculum) }}" class="flex min-h-[28rem] flex-col rounded-lg border border-slate-200 bg-white shadow-sm">
                                    @csrf
                                    <input type="hidden" name="grade_level" value="{{ $gradeLevelValue }}">
                                    <input type="hidden" name="semester" value="{{ $semester }}">

                                    <div class="border-b border-slate-200 bg-slate-50 px-4 py-3">
                                        <div class="flex items-center justify-between gap-3">
                                            <div>
                                                <h3 class="text-lg font-black text-slate-950">Semester {{ $semester }}</h3>
                                                <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-500">{{ $assigned->count() }} subjects assigned</p>
                                            </div>
                                            <button type="submit" class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                Save
                                            </button>
                                        </div>
                                    </div>

                                    <div class="border-b border-slate-100 px-4 py-3">
                                        <input type="search" placeholder="Search subjects" data-subject-filter="{{ $key }}" class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    </div>

                                    <div class="flex-1 overflow-y-auto px-4 py-3">
                                        <div class="space-y-2">
                                            @foreach ($subjects as $subject)
                                                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-slate-200 px-3 py-2 transition hover:border-blue-200 hover:bg-blue-50" data-subject-option="{{ $key }}" data-search-text="{{ strtolower($subject->code.' '.$subject->name.' '.($subject->teacher?->name ?? '')) }}">
                                                    <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" @checked(in_array($subject->id, $assignedIds, true)) class="mt-1 h-4 w-4 rounded border-slate-300 text-blue-700 focus:ring-blue-500">
                                                    <span class="min-w-0">
                                                        <span class="block truncate text-sm font-bold text-slate-950">{{ $subject->name }}</span>
                                                        <span class="mt-0.5 block text-xs font-semibold text-slate-500">
                                                            {{ $subject->code ?: 'No code' }}{{ $subject->teacher ? ' - '.$subject->teacher->name : '' }}
                                                        </span>
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>

                                        <p class="hidden py-8 text-center text-sm font-semibold text-slate-500" data-subject-empty="{{ $key }}">
                                            No matching subjects found.
                                        </p>
                                    </div>
                                </form>
                            @endforeach
                                </div>
                            </section>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-subject-filter]').forEach((input) => {
                input.addEventListener('input', () => {
                    const key = input.dataset.subjectFilter;
                    const query = input.value.trim().toLowerCase();
                    const options = Array.from(document.querySelectorAll(`[data-subject-option="${key}"]`));
                    const empty = document.querySelector(`[data-subject-empty="${key}"]`);
                    let visible = 0;

                    options.forEach((option) => {
                        const isMatch = option.dataset.searchText.includes(query);
                        option.classList.toggle('hidden', ! isMatch);
                        visible += isMatch ? 1 : 0;
                    });

                    empty?.classList.toggle('hidden', visible > 0);
                });
            });
        });
    </script>
@endsection
