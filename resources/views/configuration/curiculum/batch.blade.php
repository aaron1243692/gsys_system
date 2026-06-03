@extends('layouts.app')

@section('title', 'School Year / Batch')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Configuration</p>
            <h1 class="text-3xl font-black text-slate-950">School Year / Batch</h1>
        </section>

        @if (session('success') || $errors->any())
            @php
                $isSuccess = session('success') !== null;
                $feedbackTitle = $isSuccess ? 'Success!' : 'Failed!';
                $feedbackMessage = session('success') ?? $errors->first();
                $feedbackColor = $isSuccess ? 'blue' : 'red';
            @endphp

            <div id="batch-feedback-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-5 backdrop-blur-sm">
                <div class="w-full max-w-sm rounded-lg border border-slate-200 bg-white p-4 text-center text-slate-950 shadow-2xl">
                    <div class="relative">
                        <h2 class="text-xl font-black {{ $feedbackColor === 'blue' ? 'text-blue-700' : 'text-red-600' }}">{{ $feedbackTitle }}</h2>
                        <button type="button" onclick="document.getElementById('batch-feedback-modal').remove()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                            &times;
                        </button>
                    </div>

                    <p class="mx-auto mt-3 max-w-xs text-center text-sm leading-6 text-slate-600">{{ $feedbackMessage }}</p>

                    <button type="button" onclick="document.getElementById('batch-feedback-modal').remove()" class="mt-4 w-full rounded-[2rem] {{ $feedbackColor === 'blue' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-bold text-white transition hover:scale-105">
                        OK
                    </button>
                </div>
            </div>
        @endif

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-4 space-y-3">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <form method="GET" action="{{ route('configuration.curriculum.batch') }}" class="flex w-full gap-2 md:max-w-md">
                            <input type="hidden" name="curriculum_id" value="{{ $curriculumId }}">
                            <input
                                type="search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Search batch"
                                onchange="this.form.submit()"
                                onsearch="this.form.submit()"
                                class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            >
                        </form>

                        <button
                            type="button"
                            onclick="document.getElementById('add-batch-modal').showModal()"
                            class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800 md:ml-auto"
                        >
                            Add
                        </button>
                    </div>

                    <form method="GET" action="{{ route('configuration.curriculum.batch') }}" class="grid grid-cols-1 gap-2 md:grid-cols-[260px]">
                        <input type="hidden" name="search" value="{{ $search }}">
                        <select name="curriculum_id" onchange="this.form.submit()" class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">All curriculums</option>
                            @foreach ($curriculums as $curriculum)
                                <option value="{{ $curriculum->id }}" @selected((string) $curriculumId === (string) $curriculum->id)>{{ $curriculum->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>

                <dialog id="add-batch-modal" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                    <form method="POST" action="{{ route('configuration.curriculum.batch.store') }}" class="p-4">
                        @csrf
                        <div class="relative text-center">
                            <h2 class="text-xl font-black">Add</h2>
                            <button type="button" onclick="document.getElementById('add-batch-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                &times;
                            </button>
                        </div>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-batch-year">Year</label>
                        <input id="new-batch-year" type="number" name="year" value="{{ old('year') }}" min="1901" max="2155" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @php
                            $newSelectedCurriculum = $curriculums->firstWhere('id', (int) old('curriculum_id'));
                        @endphp

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-batch-curriculum-name">Curriculum</label>
                        <div class="mt-1.5 flex gap-2">
                            <input id="new-batch-curriculum-id" type="hidden" name="curriculum_id" value="{{ old('curriculum_id') }}">
                            <input id="new-batch-curriculum-name" type="text" value="{{ $newSelectedCurriculum?->name }}" placeholder="Select curriculum" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <button type="button" data-curriculum-picker data-target-id="new-batch-curriculum-id" data-target-name="new-batch-curriculum-name" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select curriculum">
                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                            </button>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <button type="button" onclick="document.getElementById('add-batch-modal').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                <th class="px-4 py-3 font-bold">Year</th>
                                <th class="px-4 py-3 font-bold">Curriculum</th>
                                <th class="px-4 py-3 font-bold">Track / Strand</th>
                                <th class="w-48 px-4 py-3 text-right font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($batches as $batch)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $batches->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $batch->id }}</td>
                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $batch->year }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $batch->curriculum?->name ?? 'No curriculum' }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $batch->curriculum?->track?->name ?? 'No track' }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('edit-batch-{{ $batch->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                Edit
                                            </button>
                                            <button type="button" onclick="document.getElementById('delete-batch-{{ $batch->id }}').showModal()" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </div>

                                        <dialog id="edit-batch-{{ $batch->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.curriculum.batch.update', $batch) }}" class="p-4">
                                                @csrf
                                                @method('PUT')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Edit</h2>
                                                    <button type="button" onclick="document.getElementById('edit-batch-{{ $batch->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="batch-year-{{ $batch->id }}">Year</label>
                                                <input id="batch-year-{{ $batch->id }}" type="number" name="year" value="{{ old('year', $batch->year) }}" min="1901" max="2155" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                @php
                                                    $selectedCurriculumId = old('curriculum_id', $batch->curriculum_id);
                                                    $selectedCurriculum = $curriculums->firstWhere('id', (int) $selectedCurriculumId);
                                                @endphp

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="batch-curriculum-name-{{ $batch->id }}">Curriculum</label>
                                                <div class="mt-1.5 flex gap-2">
                                                    <input id="batch-curriculum-id-{{ $batch->id }}" type="hidden" name="curriculum_id" value="{{ $selectedCurriculumId }}">
                                                    <input id="batch-curriculum-name-{{ $batch->id }}" type="text" value="{{ $selectedCurriculum?->name }}" placeholder="Select curriculum" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    <button type="button" data-curriculum-picker data-target-id="batch-curriculum-id-{{ $batch->id }}" data-target-name="batch-curriculum-name-{{ $batch->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select curriculum">
                                                        <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                    </button>
                                                </div>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('edit-batch-{{ $batch->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="delete-batch-{{ $batch->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.curriculum.batch.destroy', $batch) }}" class="p-4">
                                                @csrf
                                                @method('DELETE')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Delete!</h2>
                                                    <button type="button" onclick="document.getElementById('delete-batch-{{ $batch->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-3 text-center text-sm leading-6 text-slate-600">
                                                    Are you sure you want to delete batch <span class="font-bold text-slate-950">{{ $batch->year }}</span>?
                                                </p>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('delete-batch-{{ $batch->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                    <td colspan="6" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
                                        No batches found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($batches->hasPages())
                    <div class="mt-4 flex flex-col gap-3 border-t border-slate-100 pt-3 md:flex-row md:items-center md:justify-between">
                        <p class="text-sm font-semibold text-slate-500">
                            Showing {{ $batches->firstItem() }} to {{ $batches->lastItem() }} of {{ $batches->total() }}
                        </p>

                        <nav class="flex items-center gap-1" aria-label="Pagination">
                            @if ($batches->onFirstPage())
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&lt;</span>
                            @else
                                <a href="{{ $batches->previousPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&lt;</a>
                            @endif

                            @foreach ($batches->getUrlRange(1, $batches->lastPage()) as $page => $url)
                                @if ($page === $batches->currentPage())
                                    <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full bg-blue-700 px-3 text-sm font-black text-white shadow-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-blue-50 hover:text-blue-700">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($batches->hasMorePages())
                                <a href="{{ $batches->nextPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&gt;</a>
                            @else
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&gt;</span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <dialog id="curriculum-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Curriculums</h2>
                <button type="button" onclick="document.getElementById('curriculum-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="curriculum-picker-search" type="search" placeholder="Search curriculum" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

            <div class="mt-4 max-h-[60vh] overflow-y-auto rounded-lg border border-slate-200">
                <table class="w-full border-collapse text-left text-sm">
                    <thead class="sticky top-0 bg-blue-700 text-xs uppercase tracking-wider text-white">
                        <tr>
                            <th class="w-16 px-3 py-3 font-bold">No</th>
                            <th class="w-20 px-3 py-3 font-bold">ID</th>
                            <th class="px-3 py-3 font-bold">Name</th>
                            <th class="px-3 py-3 font-bold">Track / Strand</th>
                            <th class="w-24 px-3 py-3 text-right font-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($curriculums as $curriculum)
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-curriculum-row data-search-text="{{ strtolower($curriculum->id . ' ' . $curriculum->name . ' ' . ($curriculum->track?->name ?? '')) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $curriculum->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $curriculum->name }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $curriculum->track?->name ?? 'No track' }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-curriculum data-curriculum-id="{{ $curriculum->id }}" data-curriculum-name="{{ $curriculum->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">
                                    No curriculums found.
                                </td>
                            </tr>
                        @endforelse
                        <tr id="curriculum-picker-no-results" class="hidden">
                            <td colspan="5" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">
                                No matching curriculums found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let activeCurriculumIdInput = null;
            let activeCurriculumNameInput = null;
            const curriculumPickerModal = document.getElementById('curriculum-picker-modal');
            const curriculumPickerSearch = document.getElementById('curriculum-picker-search');
            const curriculumRows = Array.from(document.querySelectorAll('[data-curriculum-row]'));
            const curriculumNoResults = document.getElementById('curriculum-picker-no-results');

            document.querySelectorAll('dialog').forEach((dialog) => {
                dialog.addEventListener('click', (event) => {
                    if (event.target === dialog) {
                        dialog.close();
                    }
                });
            });

            document.querySelectorAll('[data-curriculum-picker]').forEach((button) => {
                button.addEventListener('click', () => {
                    activeCurriculumIdInput = document.getElementById(button.dataset.targetId);
                    activeCurriculumNameInput = document.getElementById(button.dataset.targetName);
                    curriculumPickerSearch.value = '';
                    curriculumRows.forEach((row) => row.classList.remove('hidden'));
                    curriculumNoResults.classList.add('hidden');
                    curriculumPickerModal.showModal();
                    curriculumPickerSearch.focus();
                });
            });

            curriculumPickerSearch.addEventListener('input', () => {
                const query = curriculumPickerSearch.value.trim().toLowerCase();
                let visibleCount = 0;

                curriculumRows.forEach((row) => {
                    const isMatch = row.dataset.searchText.includes(query);
                    row.classList.toggle('hidden', ! isMatch);
                    visibleCount += isMatch ? 1 : 0;
                });

                curriculumNoResults.classList.toggle('hidden', visibleCount > 0);
            });

            document.querySelectorAll('[data-select-curriculum]').forEach((button) => {
                button.addEventListener('click', () => {
                    if (activeCurriculumIdInput && activeCurriculumNameInput) {
                        activeCurriculumIdInput.value = button.dataset.curriculumId;
                        activeCurriculumNameInput.value = button.dataset.curriculumName;
                    }

                    curriculumPickerModal.close();
                });
            });
        });
    </script>
@endsection
