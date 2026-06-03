@extends('layouts.app')

@section('title', 'Curriculum')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Configuration</p>
            <h1 class="text-3xl font-black text-slate-950">Curriculum</h1>
        </section>

        @if (session('success') || $errors->any())
            @php
                $isSuccess = session('success') !== null;
                $feedbackTitle = $isSuccess ? 'Success!' : 'Failed!';
                $feedbackMessage = session('success') ?? $errors->first();
                $feedbackColor = $isSuccess ? 'blue' : 'red';
            @endphp

            <div id="curriculum-feedback-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-5 backdrop-blur-sm">
                <div class="w-full max-w-sm rounded-lg border border-slate-200 bg-white p-4 text-center text-slate-950 shadow-2xl">
                    <div class="relative">
                        <h2 class="text-xl font-black {{ $feedbackColor === 'blue' ? 'text-blue-700' : 'text-red-600' }}">{{ $feedbackTitle }}</h2>
                        <button type="button" onclick="document.getElementById('curriculum-feedback-modal').remove()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                            &times;
                        </button>
                    </div>

                    <p class="mx-auto mt-3 max-w-xs text-center text-sm leading-6 text-slate-600">{{ $feedbackMessage }}</p>

                    <button type="button" onclick="document.getElementById('curriculum-feedback-modal').remove()" class="mt-4 w-full rounded-[2rem] {{ $feedbackColor === 'blue' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-bold text-white transition hover:scale-105">
                        OK
                    </button>
                </div>
            </div>
        @endif

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <form method="GET" action="{{ route('configuration.curriculum.index') }}" class="flex w-full gap-2 md:max-w-md">
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search curriculum"
                            onchange="this.form.submit()"
                            onsearch="this.form.submit()"
                            class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                    </form>

                    <button
                        type="button"
                        onclick="document.getElementById('add-curriculum-modal').showModal()"
                        class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800 md:ml-auto"
                    >
                        Add
                    </button>
                </div>

                <dialog id="add-curriculum-modal" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                    <form method="POST" action="{{ route('configuration.curriculum.store') }}" class="p-4">
                        @csrf
                        <div class="relative text-center">
                            <h2 class="text-xl font-black">Add</h2>
                            <button type="button" onclick="document.getElementById('add-curriculum-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                &times;
                            </button>
                        </div>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-curriculum-name">Name</label>
                        <input id="new-curriculum-name" type="text" name="name" value="{{ old('name') }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @php
                            $newSelectedTrack = $tracks->firstWhere('id', (int) old('track_id'));
                        @endphp

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-curriculum-track-name">Track / Strand</label>
                        <div class="mt-1.5 flex gap-2">
                            <input id="new-curriculum-track-id" type="hidden" name="track_id" value="{{ old('track_id') }}">
                            <input id="new-curriculum-track-name" type="text" value="{{ $newSelectedTrack?->name }}" placeholder="Select track / strand" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <button type="button" data-track-picker data-target-id="new-curriculum-track-id" data-target-name="new-curriculum-track-name" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select track or strand">
                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                            </button>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <button type="button" onclick="document.getElementById('add-curriculum-modal').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                <th class="px-4 py-3 font-bold">Track / Strand</th>
                                <th class="w-48 px-4 py-3 text-right font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($curriculums as $curriculum)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $curriculums->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $curriculum->id }}</td>
                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $curriculum->name }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $curriculum->track?->name ?? 'No track' }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('edit-curriculum-{{ $curriculum->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                Edit
                                            </button>
                                            <button type="button" onclick="document.getElementById('delete-curriculum-{{ $curriculum->id }}').showModal()" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </div>

                                        <dialog id="edit-curriculum-{{ $curriculum->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.curriculum.update', $curriculum) }}" class="p-4">
                                                @csrf
                                                @method('PUT')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Edit</h2>
                                                    <button type="button" onclick="document.getElementById('edit-curriculum-{{ $curriculum->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="curriculum-name-{{ $curriculum->id }}">Name</label>
                                                <input id="curriculum-name-{{ $curriculum->id }}" type="text" name="name" value="{{ old('name', $curriculum->name) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                @php
                                                    $selectedTrackId = old('track_id', $curriculum->track_id);
                                                    $selectedTrack = $tracks->firstWhere('id', (int) $selectedTrackId);
                                                @endphp

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="curriculum-track-name-{{ $curriculum->id }}">Track / Strand</label>
                                                <div class="mt-1.5 flex gap-2">
                                                    <input id="curriculum-track-id-{{ $curriculum->id }}" type="hidden" name="track_id" value="{{ $selectedTrackId }}">
                                                    <input id="curriculum-track-name-{{ $curriculum->id }}" type="text" value="{{ $selectedTrack?->name }}" placeholder="Select track / strand" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    <button type="button" data-track-picker data-target-id="curriculum-track-id-{{ $curriculum->id }}" data-target-name="curriculum-track-name-{{ $curriculum->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select track or strand">
                                                        <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                    </button>
                                                </div>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('edit-curriculum-{{ $curriculum->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="delete-curriculum-{{ $curriculum->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.curriculum.destroy', $curriculum) }}" class="p-4">
                                                @csrf
                                                @method('DELETE')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Delete!</h2>
                                                    <button type="button" onclick="document.getElementById('delete-curriculum-{{ $curriculum->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-3 text-center text-sm leading-6 text-slate-600">
                                                    Are you sure you want to delete <span class="font-bold text-slate-950">{{ $curriculum->name }}</span>?
                                                </p>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('delete-curriculum-{{ $curriculum->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                    <td colspan="5" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
                                        No curriculums found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($curriculums->hasPages())
                    <div class="mt-4 flex flex-col gap-3 border-t border-slate-100 pt-3 md:flex-row md:items-center md:justify-between">
                        <p class="text-sm font-semibold text-slate-500">
                            Showing {{ $curriculums->firstItem() }} to {{ $curriculums->lastItem() }} of {{ $curriculums->total() }}
                        </p>

                        <nav class="flex items-center gap-1" aria-label="Pagination">
                            @if ($curriculums->onFirstPage())
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&lt;</span>
                            @else
                                <a href="{{ $curriculums->previousPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&lt;</a>
                            @endif

                            @foreach ($curriculums->getUrlRange(1, $curriculums->lastPage()) as $page => $url)
                                @if ($page === $curriculums->currentPage())
                                    <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full bg-blue-700 px-3 text-sm font-black text-white shadow-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-blue-50 hover:text-blue-700">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($curriculums->hasMorePages())
                                <a href="{{ $curriculums->nextPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&gt;</a>
                            @else
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&gt;</span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <dialog id="track-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Tracks / Strands</h2>
                <button type="button" onclick="document.getElementById('track-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="track-picker-search" type="search" placeholder="Search track / strand" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

            <div class="mt-4 max-h-[60vh] overflow-y-auto rounded-lg border border-slate-200">
                <table class="w-full border-collapse text-left text-sm">
                    <thead class="sticky top-0 bg-blue-700 text-xs uppercase tracking-wider text-white">
                        <tr>
                            <th class="w-16 px-3 py-3 font-bold">No</th>
                            <th class="w-20 px-3 py-3 font-bold">ID</th>
                            <th class="px-3 py-3 font-bold">Name</th>
                            <th class="w-24 px-3 py-3 text-right font-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tracks as $track)
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-track-row data-search-text="{{ strtolower($track->id . ' ' . $track->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $track->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $track->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-track data-track-id="{{ $track->id }}" data-track-name="{{ $track->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">
                                    No tracks found.
                                </td>
                            </tr>
                        @endforelse
                        <tr id="track-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">
                                No matching tracks found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let activeTrackIdInput = null;
            let activeTrackNameInput = null;
            const trackPickerModal = document.getElementById('track-picker-modal');
            const trackPickerSearch = document.getElementById('track-picker-search');
            const trackRows = Array.from(document.querySelectorAll('[data-track-row]'));
            const trackNoResults = document.getElementById('track-picker-no-results');

            document.querySelectorAll('dialog').forEach((dialog) => {
                dialog.addEventListener('click', (event) => {
                    if (event.target === dialog) {
                        dialog.close();
                    }
                });
            });

            document.querySelectorAll('[data-track-picker]').forEach((button) => {
                button.addEventListener('click', () => {
                    activeTrackIdInput = document.getElementById(button.dataset.targetId);
                    activeTrackNameInput = document.getElementById(button.dataset.targetName);
                    trackPickerSearch.value = '';
                    trackRows.forEach((row) => row.classList.remove('hidden'));
                    trackNoResults.classList.add('hidden');
                    trackPickerModal.showModal();
                    trackPickerSearch.focus();
                });
            });

            trackPickerSearch.addEventListener('input', () => {
                const query = trackPickerSearch.value.trim().toLowerCase();
                let visibleCount = 0;

                trackRows.forEach((row) => {
                    const isMatch = row.dataset.searchText.includes(query);
                    row.classList.toggle('hidden', ! isMatch);
                    visibleCount += isMatch ? 1 : 0;
                });

                trackNoResults.classList.toggle('hidden', visibleCount > 0);
            });

            document.querySelectorAll('[data-select-track]').forEach((button) => {
                button.addEventListener('click', () => {
                    if (activeTrackIdInput && activeTrackNameInput) {
                        activeTrackIdInput.value = button.dataset.trackId;
                        activeTrackNameInput.value = button.dataset.trackName;
                    }

                    trackPickerModal.close();
                });
            });
        });
    </script>
@endsection
