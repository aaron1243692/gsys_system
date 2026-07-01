@extends('layouts.app')

@section('title', 'Grades')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Reports / Grades</p>
            <h1 class="text-3xl font-black text-slate-950">Grades</h1>
        </section>

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-3 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <form method="GET" action="{{ route('report.grades') }}" class="flex w-full gap-2 md:max-w-md">
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search student, class, subject, or teacher"
                            class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                        <button type="submit" class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                            Search
                        </button>
                    </form>
                </div>

                @unless ($gradeDataAvailable)
                    <div class="mb-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-800">
                        {{ $gradeDataMessage }}
                    </div>
                @endunless

                <div class="flex flex-1 items-start overflow-x-auto rounded-lg border border-slate-200 min-h-0">
                    <table class="w-full border-collapse text-left text-sm">
                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                            <tr>
                                <th class="w-20 px-4 py-3 font-bold">No</th>
                                <th class="px-4 py-3 font-bold">Student</th>
                                <th class="px-4 py-3 font-bold">Class</th>
                                <th class="px-4 py-3 font-bold">Subject</th>
                                <th class="px-4 py-3 font-bold">Academic Year</th>
                                <th class="px-4 py-3 font-bold">Teacher</th>
                                <th class="w-32 px-4 py-3 font-bold">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($grades as $grade)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-700">
                                        {{ $grades->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <div class="font-bold text-slate-950">{{ $grade->student_name }}</div>
                                        <div class="text-xs font-semibold text-slate-500">ID: {{ $grade->student_id ?? $grade->student_info_id }}</div>
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">
                                        {{ $grade->class_name ?? '-' }}
                                        <div class="text-xs font-semibold text-slate-500">{{ $grade->grade_level_name ?? 'No grade level' }}</div>
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">
                                        {{ $grade->subject_name ?? 'No subject assigned' }}
                                        @if ($grade->subject_code)
                                            <div class="text-xs font-semibold text-slate-500">{{ $grade->subject_code }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $grade->academic_year_name ?? '-' }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $grade->teacher_name ?? 'Unassigned' }}</td>
                                    <td class="px-4 py-2">
                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">Not encoded</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
                                        No enrolled student subject records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($grades->hasPages())
                    <div class="mt-3">
                        {{ $grades->links() }}
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
