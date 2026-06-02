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

            <div id="class-feedback-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-5 backdrop-blur-sm">
                <div class="w-full max-w-sm rounded-lg border border-slate-200 bg-white p-4 text-center text-slate-950 shadow-2xl">
                    <div class="relative">
                        <h2 class="text-xl font-black {{ $feedbackColor === 'blue' ? 'text-blue-700' : 'text-red-600' }}">{{ $feedbackTitle }}</h2>
                        <button type="button" onclick="document.getElementById('class-feedback-modal').remove()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                            &times;
                        </button>
                    </div>

                    <p class="mx-auto mt-3 max-w-xs text-center text-sm leading-6 text-slate-600">{{ $feedbackMessage }}</p>

                    <button type="button" onclick="document.getElementById('class-feedback-modal').remove()" class="mt-4 w-full rounded-[2rem] {{ $feedbackColor === 'blue' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-bold text-white transition hover:scale-105">
                        OK
                    </button>
                </div>
            </div>
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
                    <form method="POST" action="{{ route('configuration.curriculum.class.store') }}" class="p-4">
                        @csrf
                        <div class="relative text-center">
                            <h2 class="text-xl font-black">Add</h2>
                            <button type="button" onclick="document.getElementById('add-class-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                &times;
                            </button>
                        </div>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-class-grlvl">Grade Level</label>
                        <select id="new-class-grlvl" name="grlvl_id" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">Select grade level</option>
                            @foreach ($gradeLevels as $gradeLevel)
                                <option value="{{ $gradeLevel->id }}" @selected((string) old('grlvl_id') === (string) $gradeLevel->id)>{{ $gradeLevel->name }}</option>
                            @endforeach
                        </select>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-class-acady">Academic Year</label>
                        <select id="new-class-acady" name="acady_id" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">Select academic year</option>
                            @foreach ($academicYears as $academicYear)
                                <option value="{{ $academicYear->id }}" @selected((string) old('acady_id') === (string) $academicYear->id)>{{ $academicYear->name }}</option>
                            @endforeach
                        </select>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-class-name">Name</label>
                        <input id="new-class-name" type="text" name="name" value="{{ old('name') }}" placeholder="Example: Section A" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

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

                <div class="flex flex-1 items-start overflow-x-auto rounded-lg border border-slate-200 min-h-0">
                    <table class="w-full border-collapse text-left text-sm">
                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                            <tr>
                                <th class="w-20 px-4 py-3 font-bold">No</th>
                                <th class="w-24 px-4 py-3 font-bold">ID</th>
                                <th class="px-4 py-3 font-bold">Name</th>
                                <th class="px-4 py-3 font-bold">Grade Level</th>
                                <th class="px-4 py-3 font-bold">Academic Year</th>
                                <th class="w-64 px-4 py-3 text-right font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($classes as $class)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $classes->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $class->id }}</td>
                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $class->name }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $class->gradeLevel?->name }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $class->academicYear?->name }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('subjects-class-{{ $class->id }}').showModal()" class="rounded-[2rem] border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 transition hover:scale-110 hover:bg-slate-50">
                                                Subjects
                                            </button>
                                            <button type="button" onclick="document.getElementById('edit-class-{{ $class->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                Edit
                                            </button>
                                            <button type="button" onclick="document.getElementById('delete-class-{{ $class->id }}').showModal()" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </div>

                                        <dialog id="subjects-class-{{ $class->id }}" class="m-auto w-full max-w-2xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <div class="p-4">
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Subjects</h2>
                                                    <button type="button" onclick="document.getElementById('subjects-class-{{ $class->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-2 text-center text-sm font-semibold text-slate-500">{{ $class->name }}</p>

                                                @php
                                                    $assignedSubjectIds = $class->classSubjects->pluck('sub_id')->all();
                                                    $availableSubjects = $subjects->reject(fn ($subject) => in_array($subject->id, $assignedSubjectIds, true));
                                                @endphp

                                                <div class="mt-4 flex justify-end">
                                                    <button type="button" onclick="document.getElementById('add-subject-class-{{ $class->id }}').showModal()" class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Add
                                                    </button>
                                                </div>

                                                <div class="mt-4 overflow-x-auto rounded-lg border border-slate-200">
                                                    <table class="w-full border-collapse text-left text-sm">
                                                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                                                            <tr>
                                                                <th class="w-20 px-4 py-3 font-bold">No</th>
                                                                <th class="w-24 px-4 py-3 font-bold">ID</th>
                                                                <th class="w-32 px-4 py-3 font-bold">Code</th>
                                                                <th class="px-4 py-3 font-bold">Name</th>
                                                                <th class="w-32 px-4 py-3 text-right font-bold">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($class->classSubjects as $classSubject)
                                                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $classSubject->subject?->id ?? $classSubject->sub_id }}</td>
                                                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $classSubject->subject?->code ?: '-' }}</td>
                                                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $classSubject->subject?->name ?? 'Deleted subject' }}</td>
                                                                    <td class="px-4 py-2">
                                                                        <form method="POST" action="{{ route('configuration.curriculum.class.subjects.destroy', $classSubject) }}" class="flex justify-end">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                                                Delete
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="5" class="px-4 py-8 text-center text-sm font-semibold text-slate-500">
                                                                        No subjects assigned.
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="mt-4 flex justify-end">
                                                    <button type="button" onclick="document.getElementById('subjects-class-{{ $class->id }}').close()" class="rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </dialog>

                                        <dialog id="add-subject-class-{{ $class->id }}" class="m-auto w-full max-w-2xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <div class="p-4">
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Add Subject</h2>
                                                    <button type="button" onclick="document.getElementById('add-subject-class-{{ $class->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <input
                                                    type="search"
                                                    placeholder="Search subject"
                                                    data-subject-search="add-subject-class-{{ $class->id }}"
                                                    class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                                >

                                                <div class="mt-4 overflow-x-auto rounded-lg border border-slate-200">
                                                    <table class="w-full border-collapse text-left text-sm">
                                                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                                                            <tr>
                                                                <th class="w-20 px-4 py-3 font-bold">No</th>
                                                                <th class="w-24 px-4 py-3 font-bold">ID</th>
                                                                <th class="w-32 px-4 py-3 font-bold">Code</th>
                                                                <th class="px-4 py-3 font-bold">Name</th>
                                                                <th class="w-32 px-4 py-3 text-right font-bold">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($availableSubjects as $subject)
                                                                <tr class="border-b border-slate-200 hover:bg-slate-50" data-subject-row="add-subject-class-{{ $class->id }}" data-subject-text="{{ strtolower($subject->id . ' ' . $subject->code . ' ' . $subject->name) }}">
                                                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $subject->id }}</td>
                                                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $subject->code ?: '-' }}</td>
                                                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $subject->name }}</td>
                                                                    <td class="px-4 py-2">
                                                                        <form method="POST" action="{{ route('configuration.curriculum.class.subjects.store', $class) }}" class="flex justify-end">
                                                                            @csrf
                                                                            <input type="hidden" name="sub_id" value="{{ $subject->id }}">
                                                                            <button type="submit" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                                                Select
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="5" class="px-4 py-8 text-center text-sm font-semibold text-slate-500">
                                                                        No subjects available.
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="mt-4 flex justify-end">
                                                    <button type="button" onclick="document.getElementById('add-subject-class-{{ $class->id }}').close()" class="rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </dialog>

                                        <dialog id="edit-class-{{ $class->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.curriculum.class.update', $class) }}" class="p-4">
                                                @csrf
                                                @method('PUT')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Edit</h2>
                                                    <button type="button" onclick="document.getElementById('edit-class-{{ $class->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="class-grlvl-{{ $class->id }}">Grade Level</label>
                                                <select id="class-grlvl-{{ $class->id }}" name="grlvl_id" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    @foreach ($gradeLevels as $gradeLevel)
                                                        <option value="{{ $gradeLevel->id }}" @selected((string) old('grlvl_id', $class->grlvl_id) === (string) $gradeLevel->id)>{{ $gradeLevel->name }}</option>
                                                    @endforeach
                                                </select>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="class-acady-{{ $class->id }}">Academic Year</label>
                                                <select id="class-acady-{{ $class->id }}" name="acady_id" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    @foreach ($academicYears as $academicYear)
                                                        <option value="{{ $academicYear->id }}" @selected((string) old('acady_id', $class->acady_id) === (string) $academicYear->id)>{{ $academicYear->name }}</option>
                                                    @endforeach
                                                </select>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="class-name-{{ $class->id }}">Name</label>
                                                <input id="class-name-{{ $class->id }}" type="text" name="name" value="{{ old('name', $class->name) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

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
                                    <td colspan="6" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const openModalId = @json(session('open_modal'));

            document.querySelectorAll('dialog').forEach((dialog) => {
                dialog.addEventListener('click', (event) => {
                    if (event.target === dialog) {
                        dialog.close();
                    }
                });
            });

            document.querySelectorAll('[data-subject-search]').forEach((input) => {
                input.addEventListener('input', () => {
                    const target = input.dataset.subjectSearch;
                    const term = input.value.trim().toLowerCase();

                    document.querySelectorAll(`[data-subject-row="${target}"]`).forEach((row) => {
                        row.hidden = !row.dataset.subjectText.includes(term);
                    });
                });
            });

            if (openModalId) {
                const modal = document.getElementById(openModalId);

                if (modal && typeof modal.showModal === 'function') {
                    modal.showModal();
                }
            }
        });
    </script>
@endsection
