@extends('layouts.app')

@section('title', 'Teacher Load')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Schedule &amp; Load</p>
            <h1 class="text-3xl font-black text-slate-950">Teacher Load</h1>
        </section>

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <form method="GET" action="{{ route('academic.schedule-load.teacher-load') }}" class="flex w-full gap-2 md:max-w-md">
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search teacher, subject, or class"
                            onchange="this.form.submit()"
                            onsearch="this.form.submit()"
                            class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                    </form>
                </div>

                <div class="flex flex-1 items-start overflow-x-auto rounded-lg border border-slate-200 min-h-0">
                    <table class="w-full border-collapse text-left text-sm">
                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                            <tr>
                                <th class="w-20 px-4 py-3 font-bold">No</th>
                                <th class="w-24 px-4 py-3 font-bold">ID</th>
                                <th class="px-4 py-3 font-bold">Name</th>
                                <th class="px-4 py-3 font-bold">Subjects</th>
                                <th class="px-4 py-3 font-bold">Advisory Class</th>
                                <th class="w-32 px-4 py-3 text-right font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($teachers as $teacher)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $teachers->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $teacher->id }}</td>
                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $teacher->name }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">
                                        {{ $teacher->subjects->count() }}
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">
                                        {{ $teacher->advisoryClasses->pluck('name')->join(', ') ?: 'No advisory class' }}
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <button type="button" onclick="document.getElementById('teacher-subjects-{{ $teacher->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                            Subjects
                                        </button>

                                        <dialog id="teacher-subjects-{{ $teacher->id }}" class="m-auto w-full max-w-2xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <div class="scrollbar-none max-h-[85vh] overflow-y-auto p-4">
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Subjects</h2>
                                                    <button type="button" onclick="document.getElementById('teacher-subjects-{{ $teacher->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-2 text-center text-sm font-semibold text-slate-500">{{ $teacher->name }}</p>

                                                <div class="scrollbar-none mt-4 overflow-x-auto rounded-lg border border-slate-200">
                                                    <table class="w-full border-collapse text-left text-sm">
                                                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                                                            <tr>
                                                                <th class="w-16 px-3 py-3 font-bold">No</th>
                                                                <th class="w-20 px-3 py-3 font-bold">ID</th>
                                                                <th class="w-32 px-3 py-3 font-bold">Code</th>
                                                                <th class="px-3 py-3 font-bold">Name</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($teacher->subjects as $subject)
                                                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                                                    <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                                                    <td class="px-3 py-2 font-semibold text-slate-700">{{ $subject->id }}</td>
                                                                    <td class="px-3 py-2 font-semibold text-slate-700">{{ $subject->code ?: '-' }}</td>
                                                                    <td class="px-3 py-2 font-bold text-slate-950">{{ $subject->name }}</td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">
                                                                        No subjects loaded.
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </dialog>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
                                        No teacher loads found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($teachers->hasPages())
                    <div class="mt-4 flex flex-col gap-3 border-t border-slate-100 pt-3 md:flex-row md:items-center md:justify-between">
                        <p class="text-sm font-semibold text-slate-500">
                            Showing {{ $teachers->firstItem() }} to {{ $teachers->lastItem() }} of {{ $teachers->total() }}
                        </p>

                        <nav class="flex items-center gap-1" aria-label="Pagination">
                            @if ($teachers->onFirstPage())
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&lt;</span>
                            @else
                                <a href="{{ $teachers->previousPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&lt;</a>
                            @endif

                            @foreach ($teachers->getUrlRange(1, $teachers->lastPage()) as $page => $url)
                                @if ($page === $teachers->currentPage())
                                    <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full bg-blue-700 px-3 text-sm font-black text-white shadow-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-blue-50 hover:text-blue-700">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($teachers->hasMorePages())
                                <a href="{{ $teachers->nextPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&gt;</a>
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
                        dialog.close();
                    }
                });
            });
        });
    </script>
@endsection
