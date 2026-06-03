@extends('layouts.app')

@section('title', 'Class')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Curriculum</p>
            <h1 class="text-3xl font-black text-slate-950">Class</h1>
        </section>

        @if (session('success') || $errors->any())
            @php
                $isSuccess = session('success') !== null;
                $feedbackTitle = $isSuccess ? 'Success!' : 'Failed!';
                $feedbackMessage = session('success') ?? $errors->first();
                $feedbackColor = $isSuccess ? 'blue' : 'red';
            @endphp

            <dialog id="class-feedback-modal" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-4 text-center text-slate-950 shadow-2xl backdrop:bg-slate-950/60 backdrop:backdrop-blur-sm">
                <div class="relative">
                    <h2 class="text-xl font-black {{ $feedbackColor === 'blue' ? 'text-blue-700' : 'text-red-600' }}">{{ $feedbackTitle }}</h2>
                    <button type="button" onclick="document.getElementById('class-feedback-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                        &times;
                    </button>
                </div>

                <p class="mx-auto mt-3 max-w-xs text-center text-sm leading-6 text-slate-600">{{ $feedbackMessage }}</p>

                <button type="button" onclick="document.getElementById('class-feedback-modal').close()" class="mt-4 w-full rounded-[2rem] {{ $feedbackColor === 'blue' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-bold text-white transition hover:scale-105">
                    OK
                </button>
            </dialog>
        @endif

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-4">
                    <form method="GET" action="{{ route('configuration.curriculum.class') }}" class="space-y-3">
                        <div class="flex flex-col gap-3 md:flex-row md:items-center">
                            <div class="flex w-full gap-2 md:max-w-md">
                                <input
                                    type="search"
                                    name="search"
                                    value="{{ $search }}"
                                    placeholder="Search class"
                                    onchange="this.form.submit()"
                                    onsearch="this.form.submit()"
                                    class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <button
                                type="button"
                                onclick="document.getElementById('add-class-modal').showModal()"
                                class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800 md:ml-auto"
                                style="border-radius: 2rem;"
                            >
                                Add
                            </button>
                        </div>

                        <div class="grid grid-cols-1 gap-2 md:grid-cols-[220px_220px]">
                            <select name="grlvl_id" onchange="this.form.submit()" class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="">All grade levels</option>
                                @foreach ($gradeLevels as $gradeLevel)
                                    <option value="{{ $gradeLevel->id }}" @selected((string) $gradeLevelId === (string) $gradeLevel->id)>
                                        {{ $gradeLevel->name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="acady_id" onchange="this.form.submit()" class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="">All academic years</option>
                                @foreach ($academicYears as $academicYear)
                                    <option value="{{ $academicYear->id }}" @selected((string) $academicYearId === (string) $academicYear->id)>
                                        {{ $academicYear->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <dialog id="add-class-modal" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                    <form method="POST" action="{{ route('configuration.curriculum.class.store') }}" class="scrollbar-none max-h-[85vh] overflow-y-auto p-4">
                        @csrf
                        <div class="relative text-center">
                            <h2 class="text-xl font-black">Add</h2>
                            <button type="button" onclick="document.getElementById('add-class-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                &times;
                            </button>
                        </div>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-class-name">Name</label>
                        <input id="new-class-name" type="text" name="name" value="{{ old('name') }}" placeholder="Example: Section A" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        @php
                            $newSelectedAdviser = $teachers->firstWhere('id', (int) old('adviser_id'));
                            $newSelectedGradeLevel = $gradeLevels->firstWhere('id', (int) old('grlvl_id'));
                            $newSelectedTrack = $tracks->firstWhere('id', (int) old('track_id'));
                            $newSelectedAcademicYear = $academicYears->firstWhere('id', (int) old('acady_id'));
                        @endphp

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-class-adviser-name">Adviser</label>
                        <div class="mt-1.5 flex gap-2">
                            <input id="new-class-adviser-id" type="hidden" name="adviser_id" value="{{ old('adviser_id') }}">
                            <input id="new-class-adviser-name" type="text" value="{{ $newSelectedAdviser?->name }}" placeholder="Select adviser" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <button type="button" data-teacher-picker data-target-id="new-class-adviser-id" data-target-name="new-class-adviser-name" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select adviser">
                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                            </button>
                        </div>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-class-grlvl-name">Grade Level</label>
                        <div class="mt-1.5 flex gap-2">
                            <input id="new-class-grlvl-id" type="hidden" name="grlvl_id" value="{{ old('grlvl_id') }}">
                            <input id="new-class-grlvl-name" type="text" value="{{ $newSelectedGradeLevel?->name }}" placeholder="Select grade level" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <button type="button" data-option-picker data-picker-type="grade-level" data-target-id="new-class-grlvl-id" data-target-name="new-class-grlvl-name" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select grade level">
                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                            </button>
                        </div>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-class-track-name">Track</label>
                        <div class="mt-1.5 flex gap-2">
                            <input id="new-class-track-id" type="hidden" name="track_id" value="{{ old('track_id') }}">
                            <input id="new-class-track-name" type="text" value="{{ $newSelectedTrack?->name }}" placeholder="Select track" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <button type="button" data-option-picker data-picker-type="track" data-target-id="new-class-track-id" data-target-name="new-class-track-name" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select track">
                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                            </button>
                        </div>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-class-acady-name">Academic Year</label>
                        <div class="mt-1.5 flex gap-2">
                            <input id="new-class-acady-id" type="hidden" name="acady_id" value="{{ old('acady_id') }}">
                            <input id="new-class-acady-name" type="text" value="{{ $newSelectedAcademicYear?->name }}" placeholder="Select academic year" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <button type="button" data-option-picker data-picker-type="academic-year" data-target-id="new-class-acady-id" data-target-name="new-class-acady-name" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select academic year">
                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                            </button>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <button type="button" onclick="document.getElementById('add-class-modal').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                Cancel
                            </button>
                            <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                Save
                            </button>
                        </div>
                    </form>
                </dialog>

                <div class="scrollbar-none flex flex-1 items-start overflow-x-auto rounded-lg border border-slate-200 min-h-0">
                    <table class="w-full border-collapse text-left text-sm">
                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                            <tr>
                                <th class="w-20 px-4 py-3 font-bold">No</th>
                                <th class="w-24 px-4 py-3 font-bold">ID</th>
                                <th class="px-4 py-3 font-bold">Name</th>
                                <th class="px-4 py-3 font-bold">Grade Level</th>
                                <th class="px-4 py-3 font-bold">Track</th>
                                <th class="px-4 py-3 font-bold">Academic Year</th>
                                <th class="px-4 py-3 font-bold">Adviser</th>
                                <th class="w-80 px-4 py-3 text-right font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($classes as $class)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $classes->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $class->id }}</td>
                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $class->name }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $class->gradeLevel?->name }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $class->track?->name ?? 'No track' }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $class->academicYear?->name }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $class->adviser?->name ?? 'No adviser' }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('edit-class-{{ $class->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                Edit
                                            </button>
                                            <button type="button" onclick="document.getElementById('delete-class-{{ $class->id }}').showModal()" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </div>

                                        <dialog id="edit-class-{{ $class->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.curriculum.class.update', $class) }}" class="scrollbar-none max-h-[85vh] overflow-y-auto p-4">
                                                @csrf
                                                @method('PUT')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Edit</h2>
                                                    <button type="button" onclick="document.getElementById('edit-class-{{ $class->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="class-name-{{ $class->id }}">Name</label>
                                                <input id="class-name-{{ $class->id }}" type="text" name="name" value="{{ old('name', $class->name) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                @php
                                                    $selectedAdviserId = old('adviser_id', $class->adviser_id);
                                                    $selectedAdviser = $teachers->firstWhere('id', (int) $selectedAdviserId);
                                                    $selectedGradeLevelId = old('grlvl_id', $class->grlvl_id);
                                                    $selectedGradeLevel = $gradeLevels->firstWhere('id', (int) $selectedGradeLevelId);
                                                    $selectedTrackId = old('track_id', $class->track_id);
                                                    $selectedTrack = $tracks->firstWhere('id', (int) $selectedTrackId);
                                                    $selectedAcademicYearId = old('acady_id', $class->acady_id);
                                                    $selectedAcademicYear = $academicYears->firstWhere('id', (int) $selectedAcademicYearId);
                                                @endphp

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="class-adviser-name-{{ $class->id }}">Adviser</label>
                                                <div class="mt-1.5 flex gap-2">
                                                    <input id="class-adviser-id-{{ $class->id }}" type="hidden" name="adviser_id" value="{{ $selectedAdviserId }}">
                                                    <input id="class-adviser-name-{{ $class->id }}" type="text" value="{{ $selectedAdviser?->name }}" placeholder="Select adviser" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    <button type="button" data-teacher-picker data-target-id="class-adviser-id-{{ $class->id }}" data-target-name="class-adviser-name-{{ $class->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select adviser">
                                                        <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                    </button>
                                                </div>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="class-grlvl-name-{{ $class->id }}">Grade Level</label>
                                                <div class="mt-1.5 flex gap-2">
                                                    <input id="class-grlvl-id-{{ $class->id }}" type="hidden" name="grlvl_id" value="{{ $selectedGradeLevelId }}">
                                                    <input id="class-grlvl-name-{{ $class->id }}" type="text" value="{{ $selectedGradeLevel?->name }}" placeholder="Select grade level" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    <button type="button" data-option-picker data-picker-type="grade-level" data-target-id="class-grlvl-id-{{ $class->id }}" data-target-name="class-grlvl-name-{{ $class->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select grade level">
                                                        <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                    </button>
                                                </div>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="class-track-name-{{ $class->id }}">Track</label>
                                                <div class="mt-1.5 flex gap-2">
                                                    <input id="class-track-id-{{ $class->id }}" type="hidden" name="track_id" value="{{ $selectedTrackId }}">
                                                    <input id="class-track-name-{{ $class->id }}" type="text" value="{{ $selectedTrack?->name }}" placeholder="Select track" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    <button type="button" data-option-picker data-picker-type="track" data-target-id="class-track-id-{{ $class->id }}" data-target-name="class-track-name-{{ $class->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select track">
                                                        <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                    </button>
                                                </div>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="class-acady-name-{{ $class->id }}">Academic Year</label>
                                                <div class="mt-1.5 flex gap-2">
                                                    <input id="class-acady-id-{{ $class->id }}" type="hidden" name="acady_id" value="{{ $selectedAcademicYearId }}">
                                                    <input id="class-acady-name-{{ $class->id }}" type="text" value="{{ $selectedAcademicYear?->name }}" placeholder="Select academic year" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    <button type="button" data-option-picker data-picker-type="academic-year" data-target-id="class-acady-id-{{ $class->id }}" data-target-name="class-acady-name-{{ $class->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select academic year">
                                                        <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                    </button>
                                                </div>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('edit-class-{{ $class->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="delete-class-{{ $class->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.curriculum.class.destroy', $class) }}" class="p-4">
                                                @csrf
                                                @method('DELETE')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Delete!</h2>
                                                    <button type="button" onclick="document.getElementById('delete-class-{{ $class->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-3 text-center text-sm leading-6 text-slate-600">
                                                    Are you sure you want to delete <span class="font-bold text-slate-950">{{ $class->name }}</span>?
                                                </p>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('delete-class-{{ $class->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                    <td colspan="8" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
                                        No classes found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($classes->hasPages())
                    <div class="mt-4 flex flex-col gap-3 border-t border-slate-100 pt-3 md:flex-row md:items-center md:justify-between">
                        <p class="text-sm font-semibold text-slate-500">
                            Showing {{ $classes->firstItem() }} to {{ $classes->lastItem() }} of {{ $classes->total() }}
                        </p>

                        <nav class="flex items-center gap-1" aria-label="Pagination">
                            @if ($classes->onFirstPage())
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&lt;</span>
                            @else
                                <a href="{{ $classes->previousPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&lt;</a>
                            @endif

                            @foreach ($classes->getUrlRange(1, $classes->lastPage()) as $page => $url)
                                @if ($page === $classes->currentPage())
                                    <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full bg-blue-700 px-3 text-sm font-black text-white shadow-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-blue-50 hover:text-blue-700">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($classes->hasMorePages())
                                <a href="{{ $classes->nextPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&gt;</a>
                            @else
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&gt;</span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <dialog id="grade-level-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Grade Levels</h2>
                <button type="button" onclick="document.getElementById('grade-level-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="grade-level-picker-search" type="search" placeholder="Search grade level" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

            <div class="scrollbar-none mt-4 max-h-[60vh] overflow-y-auto rounded-lg border border-slate-200">
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
                        @forelse ($gradeLevels as $gradeLevel)
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-option-row="grade-level" data-search-text="{{ strtolower($gradeLevel->id . ' ' . $gradeLevel->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $gradeLevel->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $gradeLevel->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-option="grade-level" data-option-id="{{ $gradeLevel->id }}" data-option-name="{{ $gradeLevel->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No grade levels found.</td>
                            </tr>
                        @endforelse
                        <tr id="grade-level-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No matching grade levels found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <dialog id="track-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Tracks</h2>
                <button type="button" onclick="document.getElementById('track-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="track-picker-search" type="search" placeholder="Search track" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

            <div class="scrollbar-none mt-4 max-h-[60vh] overflow-y-auto rounded-lg border border-slate-200">
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
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-option-row="track" data-search-text="{{ strtolower($track->id . ' ' . $track->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $track->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $track->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-option="track" data-option-id="{{ $track->id }}" data-option-name="{{ $track->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No tracks found.</td>
                            </tr>
                        @endforelse
                        <tr id="track-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No matching tracks found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <dialog id="academic-year-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Academic Years</h2>
                <button type="button" onclick="document.getElementById('academic-year-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="academic-year-picker-search" type="search" placeholder="Search academic year" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

            <div class="scrollbar-none mt-4 max-h-[60vh] overflow-y-auto rounded-lg border border-slate-200">
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
                        @forelse ($academicYears as $academicYear)
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-option-row="academic-year" data-search-text="{{ strtolower($academicYear->id . ' ' . $academicYear->name . ' ' . $academicYear->year_from . ' ' . $academicYear->year_to) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $academicYear->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $academicYear->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-option="academic-year" data-option-id="{{ $academicYear->id }}" data-option-name="{{ $academicYear->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No academic years found.</td>
                            </tr>
                        @endforelse
                        <tr id="academic-year-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No matching academic years found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <dialog id="teacher-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Advisers</h2>
                <button type="button" onclick="document.getElementById('teacher-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="teacher-picker-search" type="search" placeholder="Search adviser" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

            <div class="scrollbar-none mt-4 max-h-[60vh] overflow-y-auto rounded-lg border border-slate-200">
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
                        @forelse ($teachers as $teacher)
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-teacher-row data-search-text="{{ strtolower($teacher->id . ' ' . $teacher->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $teacher->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $teacher->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-teacher data-teacher-id="{{ $teacher->id }}" data-teacher-name="{{ $teacher->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">
                                    No teachers found.
                                </td>
                            </tr>
                        @endforelse
                        <tr id="teacher-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">
                                No matching teachers found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const openModalId = @json(session('open_modal'));
            const feedbackModal = document.getElementById('class-feedback-modal');
            let activeTeacherIdInput = null;
            let activeTeacherNameInput = null;
            let activeOptionIdInput = null;
            let activeOptionNameInput = null;
            let activeOptionType = null;
            const teacherPickerModal = document.getElementById('teacher-picker-modal');
            const teacherPickerSearch = document.getElementById('teacher-picker-search');
            const teacherRows = Array.from(document.querySelectorAll('[data-teacher-row]'));
            const teacherNoResults = document.getElementById('teacher-picker-no-results');
            const optionPickerConfigs = {
                'grade-level': {
                    modal: document.getElementById('grade-level-picker-modal'),
                    search: document.getElementById('grade-level-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-option-row="grade-level"]')),
                    noResults: document.getElementById('grade-level-picker-no-results'),
                },
                track: {
                    modal: document.getElementById('track-picker-modal'),
                    search: document.getElementById('track-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-option-row="track"]')),
                    noResults: document.getElementById('track-picker-no-results'),
                },
                'academic-year': {
                    modal: document.getElementById('academic-year-picker-modal'),
                    search: document.getElementById('academic-year-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-option-row="academic-year"]')),
                    noResults: document.getElementById('academic-year-picker-no-results'),
                },
            };

            document.querySelectorAll('dialog').forEach((dialog) => {
                dialog.addEventListener('click', (event) => {
                    if (event.target === dialog) {
                        dialog.close();
                    }
                });
            });

            document.querySelectorAll('[data-teacher-picker]').forEach((button) => {
                button.addEventListener('click', () => {
                    activeTeacherIdInput = document.getElementById(button.dataset.targetId);
                    activeTeacherNameInput = document.getElementById(button.dataset.targetName);
                    teacherPickerSearch.value = '';
                    teacherRows.forEach((row) => row.classList.remove('hidden'));
                    teacherNoResults.classList.add('hidden');
                    teacherPickerModal.showModal();
                    teacherPickerSearch.focus();
                });
            });

            document.querySelectorAll('[data-option-picker]').forEach((button) => {
                button.addEventListener('click', () => {
                    const config = optionPickerConfigs[button.dataset.pickerType];

                    if (! config?.modal) {
                        return;
                    }

                    activeOptionType = button.dataset.pickerType;
                    activeOptionIdInput = document.getElementById(button.dataset.targetId);
                    activeOptionNameInput = document.getElementById(button.dataset.targetName);

                    if (config.search) {
                        config.search.value = '';
                    }

                    config.rows.forEach((row) => row.classList.remove('hidden'));
                    config.noResults?.classList.add('hidden');
                    config.modal.showModal();
                    config.search?.focus();
                });
            });

            Object.entries(optionPickerConfigs).forEach(([type, config]) => {
                config.search?.addEventListener('input', () => {
                    const query = config.search.value.trim().toLowerCase();
                    let visibleCount = 0;

                    config.rows.forEach((row) => {
                        const isMatch = row.dataset.searchText.includes(query);
                        row.classList.toggle('hidden', ! isMatch);
                        visibleCount += isMatch ? 1 : 0;
                    });

                    config.noResults?.classList.toggle('hidden', visibleCount > 0);
                });
            });

            document.querySelectorAll('[data-select-option]').forEach((button) => {
                button.addEventListener('click', () => {
                    if (activeOptionType !== button.dataset.selectOption) {
                        return;
                    }

                    if (activeOptionIdInput && activeOptionNameInput) {
                        activeOptionIdInput.value = button.dataset.optionId;
                        activeOptionNameInput.value = button.dataset.optionName;
                    }

                    optionPickerConfigs[button.dataset.selectOption]?.modal?.close();
                });
            });

            teacherPickerSearch.addEventListener('input', () => {
                const query = teacherPickerSearch.value.trim().toLowerCase();
                let visibleCount = 0;

                teacherRows.forEach((row) => {
                    const isMatch = row.dataset.searchText.includes(query);
                    row.classList.toggle('hidden', ! isMatch);
                    visibleCount += isMatch ? 1 : 0;
                });

                teacherNoResults.classList.toggle('hidden', visibleCount > 0);
            });

            document.querySelectorAll('[data-select-teacher]').forEach((button) => {
                button.addEventListener('click', () => {
                    if (activeTeacherIdInput && activeTeacherNameInput) {
                        activeTeacherIdInput.value = button.dataset.teacherId;
                        activeTeacherNameInput.value = button.dataset.teacherName;
                    }

                    teacherPickerModal.close();
                });
            });

            if (openModalId) {
                const modal = document.getElementById(openModalId);

                if (modal && typeof modal.showModal === 'function') {
                    modal.showModal();
                }
            }

            if (feedbackModal && typeof feedbackModal.showModal === 'function') {
                feedbackModal.showModal();
            }
        });
    </script>
@endsection
