@extends('layouts.app')

@section('title', 'Subjects')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Curriculum</p>
            <h1 class="text-3xl font-black text-slate-950">Subjects</h1>
        </section>

        @if (session('success') || $errors->any())
            @php
                $isSuccess = session('success') !== null;
                $feedbackTitle = $isSuccess ? 'Success!' : 'Failed!';
                $feedbackMessage = session('success') ?? $errors->first();
                $feedbackColor = $isSuccess ? 'blue' : 'red';
            @endphp

            <div id="subject-feedback-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-5 backdrop-blur-sm">
                <div class="w-full max-w-sm rounded-lg border border-slate-200 bg-white p-4 text-center text-slate-950 shadow-2xl">
                    <div class="relative">
                        <h2 class="text-xl font-black {{ $feedbackColor === 'blue' ? 'text-blue-700' : 'text-red-600' }}">{{ $feedbackTitle }}</h2>
                        <button type="button" onclick="document.getElementById('subject-feedback-modal').remove()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                            &times;
                        </button>
                    </div>

                    <p class="mx-auto mt-3 max-w-xs text-center text-sm leading-6 text-slate-600">{{ $feedbackMessage }}</p>

                    <button type="button" onclick="document.getElementById('subject-feedback-modal').remove()" class="mt-4 w-full rounded-[2rem] {{ $feedbackColor === 'blue' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-bold text-white transition hover:scale-105">
                        OK
                    </button>
                </div>
            </div>
        @endif

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-4">
                    <form method="GET" action="{{ route('configuration.curriculum.subjects') }}" class="space-y-3">
                        <div class="flex flex-col gap-3 md:flex-row md:items-center">
                            <div class="flex w-full gap-2 md:max-w-md">
                                <input
                                    type="search"
                                    name="search"
                                    value="{{ $search }}"
                                    placeholder="Search subject"
                                    onchange="this.form.submit()"
                                    onsearch="this.form.submit()"
                                    class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >
                            </div>

                            <button
                                type="button"
                                onclick="document.getElementById('add-subject-modal').showModal()"
                                class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800 md:ml-auto"
                                style="border-radius: 2rem;"
                            >
                                Add
                            </button>
                        </div>

                        <div class="grid grid-cols-1 gap-2 md:grid-cols-[220px]">
                            <select name="subcat_id" onchange="this.form.submit()" class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                <option value="">All categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected((string) $categoryId === (string) $category->id)>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>

                <dialog id="add-subject-modal" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                    <form method="POST" action="{{ route('configuration.curriculum.subjects.store') }}" class="p-4">
                        @csrf
                        <div class="relative text-center">
                            <h2 class="text-xl font-black">Add</h2>
                            <button type="button" onclick="document.getElementById('add-subject-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                &times;
                            </button>
                        </div>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-subject-name">Name</label>
                        <input id="new-subject-name" type="text" name="name" value="{{ old('name') }}" placeholder="Example: Mathematics" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-subject-category">Category</label>
                        <select id="new-subject-category" name="subcat_id" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <option value="">No category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected((string) old('subcat_id') === (string) $category->id)>{{ $category->name }}</option>
                            @endforeach
                        </select>

                        @php
                            $newSelectedTeacher = $teachers->firstWhere('id', (int) old('teacher_id'));
                        @endphp

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-subject-teacher-name">Teacher</label>
                        <div class="mt-1.5 flex gap-2">
                            <input id="new-subject-teacher-id" type="hidden" name="teacher_id" value="{{ old('teacher_id') }}">
                            <input id="new-subject-teacher-name" type="text" value="{{ $newSelectedTeacher?->name }}" placeholder="Select teacher" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            <button type="button" data-teacher-picker data-target-id="new-subject-teacher-id" data-target-name="new-subject-teacher-name" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select teacher">
                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                            </button>
                        </div>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-subject-code">Code</label>
                        <input id="new-subject-code" type="text" name="code" value="{{ old('code') }}" placeholder="Optional" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <div class="mt-4 flex gap-2">
                            <button type="button" onclick="document.getElementById('add-subject-modal').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                <th class="w-32 px-4 py-3 font-bold">Code</th>
                                <th class="px-4 py-3 font-bold">Name</th>
                                <th class="px-4 py-3 font-bold">Category</th>
                                <th class="px-4 py-3 font-bold">Teacher</th>
                                <th class="w-48 px-4 py-3 text-right font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subjects as $subject)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $subjects->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $subject->id }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $subject->code ?: '-' }}</td>
                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $subject->name }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $subject->category?->name ?? 'No category' }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $subject->teacher?->name ?? 'No teacher' }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('edit-subject-{{ $subject->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                Edit
                                            </button>
                                            <button type="button" onclick="document.getElementById('delete-subject-{{ $subject->id }}').showModal()" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </div>

                                        <dialog id="edit-subject-{{ $subject->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.curriculum.subjects.update', $subject) }}" class="p-4">
                                                @csrf
                                                @method('PUT')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Edit</h2>
                                                    <button type="button" onclick="document.getElementById('edit-subject-{{ $subject->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="subject-name-{{ $subject->id }}">Name</label>
                                                <input id="subject-name-{{ $subject->id }}" type="text" name="name" value="{{ old('name', $subject->name) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="subject-category-{{ $subject->id }}">Category</label>
                                                <select id="subject-category-{{ $subject->id }}" name="subcat_id" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    <option value="">No category</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" @selected((string) old('subcat_id', $subject->subcat_id) === (string) $category->id)>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>

                                                @php
                                                    $selectedTeacherId = old('teacher_id', $subject->teacher_id);
                                                    $selectedTeacher = $teachers->firstWhere('id', (int) $selectedTeacherId);
                                                @endphp

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="subject-teacher-name-{{ $subject->id }}">Teacher</label>
                                                <div class="mt-1.5 flex gap-2">
                                                    <input id="subject-teacher-id-{{ $subject->id }}" type="hidden" name="teacher_id" value="{{ $selectedTeacherId }}">
                                                    <input id="subject-teacher-name-{{ $subject->id }}" type="text" value="{{ $selectedTeacher?->name }}" placeholder="Select teacher" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    <button type="button" data-teacher-picker data-target-id="subject-teacher-id-{{ $subject->id }}" data-target-name="subject-teacher-name-{{ $subject->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select teacher">
                                                        <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                    </button>
                                                </div>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="subject-code-{{ $subject->id }}">Code</label>
                                                <input id="subject-code-{{ $subject->id }}" type="text" name="code" value="{{ old('code', $subject->code) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('edit-subject-{{ $subject->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="delete-subject-{{ $subject->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.curriculum.subjects.destroy', $subject) }}" class="p-4">
                                                @csrf
                                                @method('DELETE')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Delete!</h2>
                                                    <button type="button" onclick="document.getElementById('delete-subject-{{ $subject->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-3 text-center text-sm leading-6 text-slate-600">
                                                    Are you sure you want to permanently delete <span class="font-bold text-slate-950">{{ $subject->name }}</span>?
                                                </p>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('delete-subject-{{ $subject->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                        No subjects found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($subjects->hasPages())
                    <div class="mt-4 flex flex-col gap-3 border-t border-slate-100 pt-3 md:flex-row md:items-center md:justify-between">
                        <p class="text-sm font-semibold text-slate-500">
                            Showing {{ $subjects->firstItem() }} to {{ $subjects->lastItem() }} of {{ $subjects->total() }}
                        </p>

                        <nav class="flex items-center gap-1" aria-label="Pagination">
                            @if ($subjects->onFirstPage())
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&lt;</span>
                            @else
                                <a href="{{ $subjects->previousPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&lt;</a>
                            @endif

                            @foreach ($subjects->getUrlRange(1, $subjects->lastPage()) as $page => $url)
                                @if ($page === $subjects->currentPage())
                                    <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full bg-blue-700 px-3 text-sm font-black text-white shadow-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-blue-50 hover:text-blue-700">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($subjects->hasMorePages())
                                <a href="{{ $subjects->nextPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&gt;</a>
                            @else
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&gt;</span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <dialog id="teacher-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Teachers</h2>
                <button type="button" onclick="document.getElementById('teacher-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="teacher-picker-search" type="search" placeholder="Search teacher" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

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
            let activeTeacherIdInput = null;
            let activeTeacherNameInput = null;
            const teacherPickerModal = document.getElementById('teacher-picker-modal');
            const teacherPickerSearch = document.getElementById('teacher-picker-search');
            const teacherRows = Array.from(document.querySelectorAll('[data-teacher-row]'));
            const teacherNoResults = document.getElementById('teacher-picker-no-results');

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
        });
    </script>
@endsection
