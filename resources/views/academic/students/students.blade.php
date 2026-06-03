@extends('layouts.app')

@section('title', 'Academic Students')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Students</p>
            <h1 class="text-3xl font-black text-slate-950">Students</h1>
        </section>

        @if (session('success') || $errors->any())
            @php
                $isSuccess = session('success') !== null;
                $feedbackTitle = $isSuccess ? 'Success!' : 'Failed!';
                $feedbackMessage = session('success') ?? $errors->first();
                $feedbackColor = $isSuccess ? 'blue' : 'red';
            @endphp

            <div id="academic-students-feedback-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-5 backdrop-blur-sm">
                <div class="w-full max-w-sm rounded-lg border border-slate-200 bg-white p-4 text-center text-slate-950 shadow-2xl">
                    <div class="relative">
                        <h2 class="text-xl font-black {{ $feedbackColor === 'blue' ? 'text-blue-700' : 'text-red-600' }}">{{ $feedbackTitle }}</h2>
                        <button type="button" onclick="document.getElementById('academic-students-feedback-modal').remove()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                            &times;
                        </button>
                    </div>

                    <p class="mx-auto mt-3 max-w-xs text-center text-sm leading-6 text-slate-600">{{ $feedbackMessage }}</p>

                    <button type="button" onclick="document.getElementById('academic-students-feedback-modal').remove()" class="mt-4 w-full rounded-[2rem] {{ $feedbackColor === 'blue' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-bold text-white transition hover:scale-105">
                        OK
                    </button>
                </div>
            </div>
        @endif

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <form method="GET" action="{{ route('academic.students.index') }}" class="mb-4 flex w-full gap-2 md:max-w-md">
                    <input
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Search student, LRN, grade, or class"
                        onchange="this.form.submit()"
                        onsearch="this.form.submit()"
                        class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                    >
                </form>

                <div class="flex flex-1 items-start overflow-x-auto rounded-lg border border-slate-200 min-h-0">
                    <table class="w-full border-collapse text-left text-sm">
                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                            <tr>
                                <th class="w-20 px-4 py-3 font-bold">No</th>
                                <th class="w-24 px-4 py-3 font-bold">ID</th>
                                <th class="px-4 py-3 font-bold">Student</th>
                                <th class="px-4 py-3 font-bold">Grade Level</th>
                                <th class="px-4 py-3 font-bold">Track</th>
                                <th class="px-4 py-3 font-bold">Class</th>
                                <th class="w-40 px-4 py-3 text-right font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $students->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $student->id }}</td>
                                    <td class="px-4 py-2">
                                        <p class="font-bold text-slate-950">{{ $student->name }}</p>
                                        @if ($student->lrn)
                                            <p class="text-xs font-semibold text-slate-500">LRN: {{ $student->lrn }}</p>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $student->gradeLevel?->name ?? '-' }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $student->schoolClass?->track?->name ?? '-' }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $student->schoolClass?->name ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('edit-student-{{ $student->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                Edit
                                            </button>
                                            <button type="button" onclick="document.getElementById('delete-student-{{ $student->id }}').showModal()" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </div>

                                        <dialog id="edit-student-{{ $student->id }}" class="m-auto w-full max-w-lg rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('academic.students.update', $student) }}" class="scrollbar-none max-h-[85vh] overflow-y-auto p-4">
                                                @csrf
                                                @method('PUT')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Edit</h2>
                                                    <button type="button" onclick="document.getElementById('edit-student-{{ $student->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="student-lrn-{{ $student->id }}">LRN</label>
                                                        <input id="student-lrn-{{ $student->id }}" type="text" name="lrn" value="{{ old('lrn', $student->lrn) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="student-name-{{ $student->id }}">Student</label>
                                                        <input id="student-name-{{ $student->id }}" type="text" name="name" value="{{ old('name', $student->name) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="student-grlvl-{{ $student->id }}">Grade Level</label>
                                                        <select id="student-grlvl-{{ $student->id }}" name="grlvl_id" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <option value="">Select grade level</option>
                                                            @foreach ($gradeLevels as $gradeLevel)
                                                                <option value="{{ $gradeLevel->id }}" @selected((string) old('grlvl_id', $student->grlvl_id) === (string) $gradeLevel->id)>{{ $gradeLevel->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="student-class-{{ $student->id }}">Class</label>
                                                        <select id="student-class-{{ $student->id }}" name="class_id" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <option value="">Select class</option>
                                                            @foreach ($classes as $class)
                                                                <option value="{{ $class->id }}" @selected((string) old('class_id', $student->class_id) === (string) $class->id)>{{ $class->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('edit-student-{{ $student->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="delete-student-{{ $student->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('academic.students.destroy', $student) }}" class="p-4">
                                                @csrf
                                                @method('DELETE')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Delete!</h2>
                                                    <button type="button" onclick="document.getElementById('delete-student-{{ $student->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-3 text-center text-sm leading-6 text-slate-600">
                                                    Are you sure you want to delete <span class="font-bold text-slate-950">{{ $student->name }}</span>?
                                                </p>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('delete-student-{{ $student->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                    <td colspan="7" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
                                        No academic students found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($students->hasPages())
                    <div class="mt-4 flex flex-col gap-3 border-t border-slate-100 pt-3 md:flex-row md:items-center md:justify-between">
                        <p class="text-sm font-semibold text-slate-500">
                            Showing {{ $students->firstItem() }} to {{ $students->lastItem() }} of {{ $students->total() }}
                        </p>

                        <nav class="flex items-center gap-1" aria-label="Pagination">
                            @if ($students->onFirstPage())
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&lt;</span>
                            @else
                                <a href="{{ $students->previousPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&lt;</a>
                            @endif

                            @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                                @if ($page === $students->currentPage())
                                    <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full bg-blue-700 px-3 text-sm font-black text-white shadow-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-blue-50 hover:text-blue-700">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($students->hasMorePages())
                                <a href="{{ $students->nextPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&gt;</a>
                            @else
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&gt;</span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
