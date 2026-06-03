@extends('layouts.app')

@section('title', 'Pre-enlistment')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Students</p>
            <h1 class="text-3xl font-black text-slate-950">Pre-enlistment</h1>
        </section>

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-4 grid grid-cols-1 gap-2 md:grid-cols-[minmax(240px,420px)_220px_180px]">
                    <input type="search" placeholder="Search pre-enlistment" class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                    <select class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        <option>All academic years</option>
                    </select>
                    <select class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                        <option>All status</option>
                        <option>Pending</option>
                        <option>Approved</option>
                        <option>Declined</option>
                    </select>
                </div>

                <div class="flex flex-1 items-start overflow-x-auto rounded-lg border border-slate-200 min-h-0">
                    <table class="w-full border-collapse text-left text-sm">
                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                            <tr>
                                <th class="w-20 px-4 py-3 font-bold">No</th>
                                <th class="w-24 px-4 py-3 font-bold">ID</th>
                                <th class="px-4 py-3 font-bold">Student</th>
                                <th class="px-4 py-3 font-bold">Academic Year</th>
                                <th class="px-4 py-3 font-bold">Grade Level</th>
                                <th class="px-4 py-3 font-bold">Track</th>
                                <th class="px-4 py-3 font-bold">Requested Class</th>
                                <th class="w-32 px-4 py-3 font-bold">Status</th>
                                <th class="w-40 px-4 py-3 text-right font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="9" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
                                    No pre-enlistment records found.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
@endsection
