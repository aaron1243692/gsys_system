@extends('layouts.app')

@section('title', 'Approval')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Reports / Grades</p>
            <h1 class="text-3xl font-black text-slate-950">Approval</h1>
        </section>

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-3 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <form method="GET" action="{{ route('report.grades.approval') }}" class="flex w-full gap-2 md:max-w-md">
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search class, subject, or teacher"
                            class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                        <button type="submit" class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                            Search
                        </button>
                    </form>
                </div>

                @unless ($approvalDataAvailable)
                    <div class="mb-3 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-800">
                        {{ $approvalDataMessage }}
                    </div>
                @endunless

                <div class="flex flex-1 items-start overflow-x-auto rounded-lg border border-slate-200 min-h-0">
                    <table class="w-full border-collapse text-left text-sm">
                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                            <tr>
                                <th class="w-20 px-4 py-3 font-bold">No</th>
                                <th class="px-4 py-3 font-bold">Class</th>
                                <th class="px-4 py-3 font-bold">Subject</th>
                                <th class="px-4 py-3 font-bold">Academic Year</th>
                                <th class="px-4 py-3 font-bold">Teacher</th>
                                <th class="w-44 px-4 py-3 font-bold">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($approvals as $approval)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-700">
                                        {{ $approvals->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">
                                        {{ $approval->class_name }}
                                        <div class="text-xs font-semibold text-slate-500">{{ $approval->grade_level_name ?? 'No grade level' }}</div>
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">
                                        {{ $approval->subject_name }}
                                        @if ($approval->subject_code)
                                            <div class="text-xs font-semibold text-slate-500">{{ $approval->subject_code }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $approval->academic_year_name ?? '-' }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $approval->teacher_name ?? 'Unassigned' }}</td>
                                    <td class="px-4 py-2">
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-700">Workflow unavailable</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
                                        No class-subject records found for grade approval.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($approvals->hasPages())
                    <div class="mt-3">
                        {{ $approvals->links() }}
                    </div>
                @endif
            </div>
        </section>
    </main>
@endsection
