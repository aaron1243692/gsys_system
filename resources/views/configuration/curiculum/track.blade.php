@extends('layouts.app')

@section('title', 'Tracks')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Configuration</p>
            <h1 class="text-3xl font-black text-slate-950">Tracks</h1>
        </section>

        @if (session('success') || $errors->any())
            @php
                $isSuccess = session('success') !== null;
                $feedbackTitle = $isSuccess ? 'Success!' : 'Failed!';
                $feedbackMessage = session('success') ?? $errors->first();
                $feedbackColor = $isSuccess ? 'blue' : 'red';
            @endphp

            <div id="track-feedback-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-5 backdrop-blur-sm">
                <div class="w-full max-w-sm rounded-lg border border-slate-200 bg-white p-4 text-center text-slate-950 shadow-2xl">
                    <div class="relative">
                        <h2 class="text-xl font-black {{ $feedbackColor === 'blue' ? 'text-blue-700' : 'text-red-600' }}">{{ $feedbackTitle }}</h2>
                        <button type="button" onclick="document.getElementById('track-feedback-modal').remove()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                            &times;
                        </button>
                    </div>

                    <p class="mx-auto mt-3 max-w-xs text-center text-sm leading-6 text-slate-600">{{ $feedbackMessage }}</p>

                    <button type="button" onclick="document.getElementById('track-feedback-modal').remove()" class="mt-4 w-full rounded-[2rem] {{ $feedbackColor === 'blue' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-bold text-white transition hover:scale-105">
                        OK
                    </button>
                </div>
            </div>
        @endif

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <form method="GET" action="{{ route('configuration.curriculum.tracks') }}" class="flex w-full gap-2 md:max-w-md">
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search track"
                            onchange="this.form.submit()"
                            onsearch="this.form.submit()"
                            class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                    </form>

                    <button
                        type="button"
                        onclick="document.getElementById('add-track-modal').showModal()"
                        class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800 md:ml-auto"
                    >
                        Add
                    </button>
                </div>

                <dialog id="add-track-modal" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                    <form method="POST" action="{{ route('configuration.curriculum.tracks.store') }}" class="p-4">
                        @csrf
                        <div class="relative text-center">
                            <h2 class="text-xl font-black">Add</h2>
                            <button type="button" onclick="document.getElementById('add-track-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                &times;
                            </button>
                        </div>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-track-name">Name</label>
                        <input id="new-track-name" type="text" name="name" value="{{ old('name') }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <div class="mt-4 flex gap-2">
                            <button type="button" onclick="document.getElementById('add-track-modal').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                Cancel
                            </button>
                            <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                Save
                            </button>
                        </div>
                    </form>
                </dialog>

                <div class="flex flex-1 items-start overflow-x-auto rounded-lg border border-slate-200 min-h-0">
                    <table class="w-full border-collapse text-left text-sm">
                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                            <tr>
                                <th class="w-20 px-4 py-3 font-bold">No</th>
                                <th class="w-24 px-4 py-3 font-bold">ID</th>
                                <th class="px-4 py-3 font-bold">Name</th>
                                <th class="w-48 px-4 py-3 text-right font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tracks as $track)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $tracks->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $track->id }}</td>
                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $track->name }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('subjects-track-{{ $track->id }}').showModal()" class="rounded-[2rem] border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 transition hover:scale-110 hover:bg-slate-50">
                                                Subjects
                                            </button>
                                            <button type="button" onclick="document.getElementById('edit-track-{{ $track->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                Edit
                                            </button>
                                            <button type="button" onclick="document.getElementById('delete-track-{{ $track->id }}').showModal()" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </div>

                                        <dialog id="subjects-track-{{ $track->id }}" class="m-auto w-full max-w-2xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <div class="p-4">
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Subjects</h2>
                                                    <button type="button" data-track-subject-cancel="track-{{ $track->id }}" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-2 text-center text-sm font-semibold text-slate-600">{{ $track->name }}</p>

                                                <div class="mt-4 flex justify-end">
                                                    <button type="button" onclick="document.getElementById('add-track-subject-{{ $track->id }}').showModal()" class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Add
                                                    </button>
                                                </div>

                                                <div class="mt-3 max-h-[55vh] overflow-y-auto rounded-lg border border-slate-200">
                                                    <table class="w-full border-collapse text-left text-sm">
                                                        <thead class="sticky top-0 bg-blue-700 text-xs uppercase tracking-wider text-white">
                                                            <tr>
                                                                <th class="w-16 px-3 py-3 font-bold">No</th>
                                                                <th class="w-20 px-3 py-3 font-bold">ID</th>
                                                                <th class="px-3 py-3 font-bold">Grade Level</th>
                                                                <th class="px-3 py-3 font-bold">Subject</th>
                                                                <th class="w-24 px-3 py-3 text-right font-bold">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody data-track-subject-list="track-{{ $track->id }}">
                                                            @php
                                                                $displayTrackSubjects = $track->trackSubjects->sortBy(fn ($trackSubject) => ($trackSubject->gradeLevel?->name ?? 'No grade level') . ' ' . ($trackSubject->subject?->name ?? ''));
                                                                $currentGradeLevelName = null;
                                                            @endphp

                                                            @forelse ($displayTrackSubjects as $trackSubject)
                                                                @if ($currentGradeLevelName !== ($trackSubject->gradeLevel?->name ?? 'No grade level'))
                                                                    @php
                                                                        $currentGradeLevelName = $trackSubject->gradeLevel?->name ?? 'No grade level';
                                                                    @endphp
                                                                    <tr class="bg-blue-50" data-grade-group-row="track-{{ $track->id }}" data-grade-level-id="{{ $trackSubject->grlvl_id }}">
                                                                        <td colspan="5" class="px-3 py-2 text-center text-sm font-black text-blue-800">
                                                                            {{ $currentGradeLevelName }}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                <tr class="border-b border-slate-200 hover:bg-slate-50" data-assigned-subject-row="track-{{ $track->id }}" data-subject-id="{{ $trackSubject->subject_id }}" data-subject-name="{{ $trackSubject->subject?->name ?? 'Deleted subject' }}" data-grade-level-id="{{ $trackSubject->grlvl_id }}" data-grade-level-name="{{ $trackSubject->gradeLevel?->name ?? 'No grade level' }}">
                                                                    <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                                                    <td class="px-3 py-2 font-semibold text-slate-700">{{ $trackSubject->id }}</td>
                                                                    <td class="px-3 py-2 font-semibold text-slate-700" data-grade-level-cell>{{ $trackSubject->gradeLevel?->name ?? 'No grade level' }}</td>
                                                                    <td class="px-3 py-2 font-bold text-slate-950">
                                                                        {{ $trackSubject->subject?->name ?? 'Deleted subject' }}
                                                                        <span class="ml-2 hidden rounded-full bg-red-50 px-2 py-0.5 text-xs font-bold text-red-600" data-remove-badge>Will remove</span>
                                                                    </td>
                                                                    <td class="px-3 py-2">
                                                                        <div class="flex justify-end">
                                                                            <button type="button" data-track-subject-remove="track-{{ $track->id }}" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                                                Delete
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr data-track-subject-empty="track-{{ $track->id }}">
                                                                    <td colspan="5" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">
                                                                        No subjects assigned.
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                            @if ($track->trackSubjects->isNotEmpty())
                                                                <tr class="hidden" data-track-subject-empty="track-{{ $track->id }}">
                                                                    <td colspan="5" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">
                                                                        No subjects assigned.
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <form method="POST" action="{{ route('configuration.curriculum.tracks.subjects.store', $track) }}" class="mt-4" data-track-subject-form="track-{{ $track->id }}">
                                                    @csrf
                                                    <div data-track-subject-inputs="track-{{ $track->id }}">
                                                        @foreach ($track->trackSubjects as $trackSubject)
                                                            <input type="hidden" name="subject_ids[]" value="{{ $trackSubject->subject_id }}" data-subject-hidden-id="{{ $trackSubject->subject_id }}">
                                                            <input type="hidden" name="subject_grlvl_ids[{{ $trackSubject->subject_id }}]" value="{{ $trackSubject->grlvl_id }}" data-grade-level-hidden-id="{{ $trackSubject->subject_id }}">
                                                        @endforeach
                                                    </div>
                                                    <p class="mb-3 hidden text-center text-sm font-bold text-blue-700" data-track-subject-selected="track-{{ $track->id }}"></p>

                                                    <div class="flex gap-2">
                                                        <button type="button" data-track-subject-cancel="track-{{ $track->id }}" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" disabled data-track-subject-save="track-{{ $track->id }}" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800 disabled:cursor-not-allowed disabled:bg-slate-300 disabled:hover:scale-100">
                                                            Save
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </dialog>

                                        <dialog id="add-track-subject-{{ $track->id }}" class="m-auto w-full max-w-2xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <div class="p-4">
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Add Subject</h2>
                                                    <button type="button" onclick="document.getElementById('add-track-subject-{{ $track->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                @php
                                                    $assignedSubjectIds = $track->trackSubjects->pluck('subject_id')->all();
                                                    $availableSubjects = $subjects->reject(fn ($subject) => in_array($subject->id, $assignedSubjectIds, true));
                                                @endphp

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="track-subject-grade-{{ $track->id }}">Grade Level</label>
                                                <select id="track-subject-grade-{{ $track->id }}" data-track-subject-grade="track-{{ $track->id }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    <option value="">Select grade level</option>
                                                    @foreach ($gradeLevels as $gradeLevel)
                                                        <option value="{{ $gradeLevel->id }}">{{ $gradeLevel->name }}</option>
                                                    @endforeach
                                                </select>

                                                <input type="search" placeholder="Search subject" data-track-subject-search="track-{{ $track->id }}" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                <div class="mt-4 max-h-[60vh] overflow-y-auto rounded-lg border border-slate-200">
                                                    <table class="w-full border-collapse text-left text-sm">
                                                        <thead class="sticky top-0 bg-blue-700 text-xs uppercase tracking-wider text-white">
                                                            <tr>
                                                                <th class="w-16 px-3 py-3 font-bold">No</th>
                                                                <th class="w-20 px-3 py-3 font-bold">ID</th>
                                                                <th class="px-3 py-3 font-bold">Name</th>
                                                                <th class="px-3 py-3 font-bold">Category</th>
                                                                <th class="px-3 py-3 font-bold">Teacher</th>
                                                                <th class="w-24 px-3 py-3 text-right font-bold">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($availableSubjects as $subject)
                                                                <tr class="border-b border-slate-200 hover:bg-slate-50" data-track-subject-row="track-{{ $track->id }}" data-search-text="{{ strtolower($subject->id . ' ' . $subject->name . ' ' . ($subject->category?->name ?? '') . ' ' . ($subject->teacher?->name ?? '')) }}">
                                                                    <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                                                    <td class="px-3 py-2 font-semibold text-slate-700">{{ $subject->id }}</td>
                                                                    <td class="px-3 py-2 font-bold text-slate-950">{{ $subject->name }}</td>
                                                                    <td class="px-3 py-2 font-semibold text-slate-700">{{ $subject->category?->name ?? 'No category' }}</td>
                                                                    <td class="px-3 py-2 font-semibold text-slate-700">{{ $subject->teacher?->name ?? 'No teacher' }}</td>
                                                                    <td class="px-3 py-2">
                                                                        <div class="flex justify-end">
                                                                            <button type="button" data-track-subject-select="track-{{ $track->id }}" data-subject-id="{{ $subject->id }}" data-subject-name="{{ $subject->name }}" data-subject-category="{{ $subject->category?->name ?? 'No category' }}" data-subject-teacher="{{ $subject->teacher?->name ?? 'No teacher' }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                                                Select
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="6" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">
                                                                        No subjects available.
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                            <tr class="hidden" data-track-subject-no-results="track-{{ $track->id }}">
                                                                <td colspan="6" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">
                                                                    No matching subjects found.
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </dialog>

                                        <dialog id="edit-track-{{ $track->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.curriculum.tracks.update', $track) }}" class="p-4">
                                                @csrf
                                                @method('PUT')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Edit</h2>
                                                    <button type="button" onclick="document.getElementById('edit-track-{{ $track->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="track-name-{{ $track->id }}">Name</label>
                                                <input id="track-name-{{ $track->id }}" type="text" name="name" value="{{ old('name', $track->name) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('edit-track-{{ $track->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="delete-track-{{ $track->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.curriculum.tracks.destroy', $track) }}" class="p-4">
                                                @csrf
                                                @method('DELETE')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Delete!</h2>
                                                    <button type="button" onclick="document.getElementById('delete-track-{{ $track->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-3 text-center text-sm leading-6 text-slate-600">
                                                    Are you sure you want to delete <span class="font-bold text-slate-950">{{ $track->name }}</span>?
                                                </p>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('delete-track-{{ $track->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-red-700">
                                                        Delete
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
                                        No tracks found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($tracks->hasPages())
                    <div class="mt-4 flex flex-col gap-3 border-t border-slate-100 pt-3 md:flex-row md:items-center md:justify-between">
                        <p class="text-sm font-semibold text-slate-500">
                            Showing {{ $tracks->firstItem() }} to {{ $tracks->lastItem() }} of {{ $tracks->total() }}
                        </p>

                        <nav class="flex items-center gap-1" aria-label="Pagination">
                            @if ($tracks->onFirstPage())
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&lt;</span>
                            @else
                                <a href="{{ $tracks->previousPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&lt;</a>
                            @endif

                            @foreach ($tracks->getUrlRange(1, $tracks->lastPage()) as $page => $url)
                                @if ($page === $tracks->currentPage())
                                    <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full bg-blue-700 px-3 text-sm font-black text-white shadow-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-blue-50 hover:text-blue-700">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($tracks->hasMorePages())
                                <a href="{{ $tracks->nextPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&gt;</a>
                            @else
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&gt;</span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('dialog').forEach((dialog) => {
                dialog.addEventListener('click', (event) => {
                    if (event.target === dialog) {
                        if (dialog.id.startsWith('subjects-track-')) {
                            resetTrackSubjectModal(`track-${dialog.id.replace('subjects-track-', '')}`);
                            return;
                        }

                        dialog.close();
                    }
                });
            });

            document.querySelectorAll('[data-track-subject-search]').forEach((input) => {
                input.addEventListener('input', () => {
                    const key = input.dataset.trackSubjectSearch;
                    const query = input.value.trim().toLowerCase();
                    const rows = Array.from(document.querySelectorAll(`[data-track-subject-row="${key}"]`));
                    const noResults = document.querySelector(`[data-track-subject-no-results="${key}"]`);
                    let visibleCount = 0;

                    rows.forEach((row) => {
                        const isMatch = row.dataset.searchText.includes(query);
                        row.classList.toggle('hidden', ! isMatch);
                        visibleCount += isMatch ? 1 : 0;
                    });

                    if (noResults) {
                        noResults.classList.toggle('hidden', visibleCount > 0);
                    }
                });
            });

            const escapeHtml = (value) => String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');

            const originalTrackSubjects = new Map();

            document.querySelectorAll('[data-track-subject-inputs]').forEach((container) => {
                const key = container.dataset.trackSubjectInputs;
                originalTrackSubjects.set(key, Array.from(document.querySelectorAll(`[data-assigned-subject-row="${key}"]`)).map((row) => ({
                    subjectId: row.dataset.subjectId,
                    gradeLevelId: row.dataset.gradeLevelId || '',
                    gradeLevelName: row.dataset.gradeLevelName || 'No grade level',
                })));
            });

            const enableTrackSubjectSave = (key) => {
                const save = document.querySelector(`[data-track-subject-save="${key}"]`);

                if (save) {
                    save.disabled = false;
                }
            };

            const updateTrackSubjectEmptyRow = (key) => {
                const rows = Array.from(document.querySelectorAll(`[data-assigned-subject-row="${key}"]`));
                const activeRows = rows.filter((row) => row.dataset.stagedRemove !== 'true');
                const emptyRow = document.querySelector(`[data-track-subject-empty="${key}"]`);

                if (emptyRow) {
                    emptyRow.classList.toggle('hidden', activeRows.length > 0);
                }

                document.querySelectorAll(`[data-grade-group-row="${key}"]`).forEach((groupRow) => {
                    const hasActiveInGroup = activeRows.some((row) => (row.dataset.gradeLevelId || '') === (groupRow.dataset.gradeLevelId || ''));
                    groupRow.classList.toggle('hidden', ! hasActiveInGroup);
                });
            };

            const rebuildTrackSubjectInputs = (key) => {
                const container = document.querySelector(`[data-track-subject-inputs="${key}"]`);

                if (! container) {
                    return;
                }

                container.innerHTML = '';

                document.querySelectorAll(`[data-assigned-subject-row="${key}"]`).forEach((row) => {
                    if (row.dataset.stagedRemove === 'true') {
                        return;
                    }

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'subject_ids[]';
                    input.value = row.dataset.subjectId;
                    input.dataset.subjectHiddenId = row.dataset.subjectId;
                    container.appendChild(input);

                    const gradeLevelInput = document.createElement('input');
                    gradeLevelInput.type = 'hidden';
                    gradeLevelInput.name = `subject_grlvl_ids[${row.dataset.subjectId}]`;
                    gradeLevelInput.value = row.dataset.gradeLevelId || '';
                    gradeLevelInput.dataset.gradeLevelHiddenId = row.dataset.subjectId;
                    container.appendChild(gradeLevelInput);
                });

                updateTrackSubjectEmptyRow(key);
            };

            const markTrackSubjectRowRemoved = (row, removed) => {
                const badge = row.querySelector('[data-remove-badge]');
                const button = row.querySelector('[data-track-subject-remove]');

                row.dataset.stagedRemove = removed ? 'true' : 'false';
                row.classList.toggle('bg-red-50', removed);
                row.classList.toggle('opacity-60', removed);
                row.classList.toggle('line-through', removed);

                if (badge) {
                    badge.classList.toggle('hidden', ! removed);
                }

                if (button) {
                    button.textContent = removed ? 'Undo' : 'Delete';
                    button.classList.toggle('border-slate-200', removed);
                    button.classList.toggle('text-slate-700', removed);
                    button.classList.toggle('hover:bg-slate-50', removed);
                    button.classList.toggle('border-red-200', ! removed);
                    button.classList.toggle('text-red-600', ! removed);
                    button.classList.toggle('hover:bg-red-50', ! removed);
                }
            };

            const resetTrackSubjectModal = (key) => {
                const trackId = key.replace('track-', '');
                const addDialog = document.getElementById(`add-track-subject-${trackId}`);
                const subjectsDialog = document.getElementById(`subjects-track-${trackId}`);
                const save = document.querySelector(`[data-track-subject-save="${key}"]`);
                const selected = document.querySelector(`[data-track-subject-selected="${key}"]`);
                const search = document.querySelector(`[data-track-subject-search="${key}"]`);
                const gradeLevelSelect = document.querySelector(`[data-track-subject-grade="${key}"]`);
                const hiddenContainer = document.querySelector(`[data-track-subject-inputs="${key}"]`);

                document.querySelectorAll(`[data-assigned-subject-row="${key}"][data-staged-new="true"]`).forEach((row) => row.remove());
                document.querySelectorAll(`[data-assigned-subject-row="${key}"]`).forEach((row) => {
                    const original = (originalTrackSubjects.get(key) ?? []).find((subject) => subject.subjectId === row.dataset.subjectId);

                    if (original) {
                        row.dataset.gradeLevelId = original.gradeLevelId;
                        row.dataset.gradeLevelName = original.gradeLevelName;
                        const gradeCell = row.querySelector('[data-grade-level-cell]');

                        if (gradeCell) {
                            gradeCell.textContent = original.gradeLevelName;
                        }
                    }

                    markTrackSubjectRowRemoved(row, false);
                });

                if (hiddenContainer) {
                    hiddenContainer.innerHTML = '';
                    (originalTrackSubjects.get(key) ?? []).forEach((subject) => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'subject_ids[]';
                        input.value = subject.subjectId;
                        input.dataset.subjectHiddenId = subject.subjectId;
                        hiddenContainer.appendChild(input);

                        const gradeLevelInput = document.createElement('input');
                        gradeLevelInput.type = 'hidden';
                        gradeLevelInput.name = `subject_grlvl_ids[${subject.subjectId}]`;
                        gradeLevelInput.value = subject.gradeLevelId;
                        gradeLevelInput.dataset.gradeLevelHiddenId = subject.subjectId;
                        hiddenContainer.appendChild(gradeLevelInput);
                    });
                }

                if (search) {
                    search.value = '';
                }

                if (gradeLevelSelect) {
                    gradeLevelSelect.value = '';
                }

                if (save) {
                    save.disabled = true;
                }

                if (selected) {
                    selected.textContent = '';
                    selected.classList.add('hidden');
                }

                document.querySelectorAll(`[data-track-subject-row="${key}"]`).forEach((row) => {
                    row.classList.remove('bg-blue-50', 'ring-2', 'ring-inset', 'ring-blue-200');
                    row.classList.remove('hidden');
                });

                document.querySelector(`[data-track-subject-no-results="${key}"]`)?.classList.add('hidden');
                updateTrackSubjectEmptyRow(key);

                if (addDialog?.open) {
                    addDialog.close();
                }

                if (subjectsDialog?.open) {
                    subjectsDialog.close();
                }
            };

            document.querySelectorAll('[data-track-subject-select]').forEach((button) => {
                button.addEventListener('click', () => {
                    const key = button.dataset.trackSubjectSelect;
                    const list = document.querySelector(`[data-track-subject-list="${key}"]`);
                    const selected = document.querySelector(`[data-track-subject-selected="${key}"]`);
                    const gradeLevelSelect = document.querySelector(`[data-track-subject-grade="${key}"]`);
                    const existingRow = document.querySelector(`[data-assigned-subject-row="${key}"][data-subject-id="${button.dataset.subjectId}"]`);
                    const gradeLevelId = gradeLevelSelect?.value ?? '';
                    const gradeLevelName = gradeLevelSelect?.selectedOptions?.[0]?.textContent ?? '';

                    if (! gradeLevelId) {
                        alert('Please select a grade level first.');
                        gradeLevelSelect?.focus();
                        return;
                    }

                    document.querySelectorAll(`[data-track-subject-row="${key}"]`).forEach((row) => {
                        row.classList.remove('bg-blue-50', 'ring-2', 'ring-inset', 'ring-blue-200');
                    });

                    button.closest('tr')?.classList.add('bg-blue-50', 'ring-2', 'ring-inset', 'ring-blue-200');

                    if (existingRow) {
                        existingRow.dataset.gradeLevelId = gradeLevelId;
                        existingRow.dataset.gradeLevelName = gradeLevelName;
                        const gradeCell = existingRow.querySelector('[data-grade-level-cell]');

                        if (gradeCell) {
                            gradeCell.textContent = gradeLevelName;
                        }

                        markTrackSubjectRowRemoved(existingRow, false);
                    } else if (list) {
                        const rowCount = document.querySelectorAll(`[data-assigned-subject-row="${key}"]`).length + 1;
                        const row = document.createElement('tr');
                        row.className = 'border-b border-slate-200 bg-blue-50 hover:bg-slate-50';
                        row.setAttribute('data-assigned-subject-row', key);
                        row.dataset.subjectId = button.dataset.subjectId;
                        row.dataset.subjectName = button.dataset.subjectName;
                        row.dataset.gradeLevelId = gradeLevelId;
                        row.dataset.gradeLevelName = gradeLevelName;
                        row.dataset.stagedNew = 'true';
                        row.innerHTML = `
                            <td class="px-3 py-2 font-semibold text-slate-500">${rowCount}</td>
                            <td class="px-3 py-2 font-semibold text-slate-700">New</td>
                            <td class="px-3 py-2 font-semibold text-slate-700" data-grade-level-cell>${escapeHtml(gradeLevelName)}</td>
                            <td class="px-3 py-2 font-bold text-slate-950">${escapeHtml(button.dataset.subjectName)} <span class="ml-2 rounded-full bg-blue-50 px-2 py-0.5 text-xs font-bold text-blue-700">New</span><span class="ml-2 hidden rounded-full bg-red-50 px-2 py-0.5 text-xs font-bold text-red-600" data-remove-badge>Will remove</span></td>
                            <td class="px-3 py-2">
                                <div class="flex justify-end">
                                    <button type="button" data-track-subject-remove="${key}" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">Delete</button>
                                </div>
                            </td>
                        `;
                        list.appendChild(row);
                    }

                    if (selected) {
                        selected.textContent = `Staged: ${gradeLevelName} - ${button.dataset.subjectName}`;
                        selected.classList.remove('hidden');
                    }

                    rebuildTrackSubjectInputs(key);
                    enableTrackSubjectSave(key);
                    document.getElementById(`add-track-subject-${key.replace('track-', '')}`)?.close();
                });
            });

            document.addEventListener('click', (event) => {
                const button = event.target.closest('[data-track-subject-remove]');

                if (! button) {
                    return;
                }

                const key = button.dataset.trackSubjectRemove;
                const row = button.closest('[data-assigned-subject-row]');

                if (! row) {
                    return;
                }

                if (row.dataset.stagedNew === 'true') {
                    row.remove();
                } else {
                    markTrackSubjectRowRemoved(row, row.dataset.stagedRemove !== 'true');
                }

                rebuildTrackSubjectInputs(key);
                enableTrackSubjectSave(key);
            });

            document.querySelectorAll('[data-track-subject-cancel]').forEach((button) => {
                button.addEventListener('click', () => resetTrackSubjectModal(button.dataset.trackSubjectCancel));
            });
        });
    </script>
@endsection
