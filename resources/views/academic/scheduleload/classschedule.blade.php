@extends('layouts.app')

@section('title', 'Class Schedule')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Schedule &amp; Load</p>
            <h1 class="text-3xl font-black text-slate-950">Class Schedule</h1>
        </section>

        @if (session('success') || $errors->any())
            @php
                $isSuccess = session('success') !== null;
                $feedbackTitle = $isSuccess ? 'Success!' : 'Failed!';
                $feedbackMessage = session('success') ?? $errors->first();
                $feedbackColor = $isSuccess ? 'blue' : 'red';
            @endphp

            <div id="class-schedule-feedback-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-5 backdrop-blur-sm">
                <div class="w-full max-w-sm rounded-lg border border-slate-200 bg-white p-4 text-center text-slate-950 shadow-2xl">
                    <div class="relative">
                        <h2 class="text-xl font-black {{ $feedbackColor === 'blue' ? 'text-blue-700' : 'text-red-600' }}">{{ $feedbackTitle }}</h2>
                        <button type="button" onclick="document.getElementById('class-schedule-feedback-modal').remove()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                            &times;
                        </button>
                    </div>

                    <p class="mx-auto mt-3 max-w-xs text-center text-sm leading-6 text-slate-600">{{ $feedbackMessage }}</p>

                    <button type="button" onclick="document.getElementById('class-schedule-feedback-modal').remove()" class="mt-4 w-full rounded-[2rem] {{ $feedbackColor === 'blue' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-bold text-white transition hover:scale-105">
                        OK
                    </button>
                </div>
            </div>
        @endif

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <form method="GET" action="{{ route('academic.schedule-load.class-schedule') }}" class="flex w-full gap-2 md:max-w-md">
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search class or adviser"
                            onchange="this.form.submit()"
                            onsearch="this.form.submit()"
                            class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                    </form>

                    <button type="button" onclick="document.getElementById('add-class-schedule-modal').showModal()" class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800 md:ml-auto">
                        Add
                    </button>
                </div>

                <dialog id="add-class-schedule-modal" class="m-auto w-full max-w-lg rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                    <form method="POST" action="{{ route('academic.schedule-load.class-schedule.store') }}" class="p-4">
                        @csrf
                        <div class="relative text-center">
                            <h2 class="text-xl font-black">Add</h2>
                            <button type="button" onclick="document.getElementById('add-class-schedule-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                &times;
                            </button>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-slate-800" for="new-class-name">Class</label>
                                <input id="new-class-name" type="text" name="name" value="{{ old('name') }}" placeholder="Example: Section A" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-800" for="new-class-grlvl-name">Grade Level</label>
                                <div class="mt-1.5 flex gap-2">
                                    <input id="new-class-grlvl" type="hidden" name="grlvl_id" value="{{ old('grlvl_id') }}">
                                    <input id="new-class-grlvl-name" type="text" value="{{ $gradeLevels->firstWhere('id', old('grlvl_id'))?->name }}" placeholder="Select grade level" readonly required class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <button type="button" data-schedule-picker data-picker-type="grade-level" data-target-id="new-class-grlvl" data-target-name="new-class-grlvl-name" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select grade level">
                                        <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-800" for="new-class-track-name">Track</label>
                                <div class="mt-1.5 flex gap-2">
                                    <input id="new-class-track" type="hidden" name="track_id" value="{{ old('track_id') }}">
                                    <input id="new-class-track-name" type="text" value="{{ $tracks->firstWhere('id', old('track_id'))?->name }}" placeholder="Select track" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <button type="button" data-schedule-picker data-picker-type="track" data-target-id="new-class-track" data-target-name="new-class-track-name" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select track">
                                        <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-800" for="new-class-acady-name">Academic Year</label>
                                <div class="mt-1.5 flex gap-2">
                                    <input id="new-class-acady" type="hidden" name="acady_id" value="{{ old('acady_id') }}">
                                    <input id="new-class-acady-name" type="text" value="{{ $academicYears->firstWhere('id', old('acady_id'))?->name }}" placeholder="Select academic year" readonly required class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <button type="button" data-schedule-picker data-picker-type="academic-year" data-target-id="new-class-acady" data-target-name="new-class-acady-name" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select academic year">
                                        <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-800" for="new-class-adviser-name">Adviser</label>
                                <div class="mt-1.5 flex gap-2">
                                    <input id="new-class-adviser" type="hidden" name="adviser_id" value="{{ old('adviser_id') }}">
                                    <input id="new-class-adviser-name" type="text" value="{{ $teachers->firstWhere('id', old('adviser_id'))?->name }}" placeholder="Select adviser" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                    <button type="button" data-schedule-picker data-picker-type="adviser" data-target-id="new-class-adviser" data-target-name="new-class-adviser-name" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select adviser">
                                        <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex gap-2">
                            <button type="button" onclick="document.getElementById('add-class-schedule-modal').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                <th class="px-4 py-3 font-bold">Class</th>
                                <th class="px-4 py-3 font-bold">Adviser</th>
                                <th class="w-56 px-4 py-3 text-right font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($classes as $class)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $classes->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $class->id }}</td>
                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $class->name }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $class->adviser?->name ?? 'No adviser' }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('schedule-class-{{ $class->id }}').showModal()" class="rounded-[2rem] border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 transition hover:scale-110 hover:bg-slate-50">
                                                Schedule
                                            </button>
                                            <button type="button" onclick="document.getElementById('edit-class-schedule-{{ $class->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                Edit
                                            </button>
                                            <button type="button" onclick="document.getElementById('delete-class-schedule-{{ $class->id }}').showModal()" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </div>

                                        <dialog id="schedule-class-{{ $class->id }}" class="m-auto w-full max-w-4xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <div class="scrollbar-none max-h-[85vh] overflow-y-auto p-4">
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Schedule</h2>
                                                    <button type="button" onclick="document.getElementById('schedule-class-{{ $class->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-2 text-center text-sm font-semibold text-slate-500">{{ $class->name }}</p>

                                                <div class="mt-4 flex justify-end">
                                                    <button type="button" onclick="document.getElementById('add-schedule-{{ $class->id }}').showModal()" class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Add
                                                    </button>
                                                </div>

                                                <div class="scrollbar-none mt-4 overflow-x-auto rounded-lg border border-slate-200">
                                                    <table class="w-full border-collapse text-left text-sm">
                                                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                                                            <tr>
                                                                <th class="w-16 px-3 py-3 font-bold">No</th>
                                                                <th class="w-20 px-3 py-3 font-bold">ID</th>
                                                                <th class="px-3 py-3 font-bold">Subject</th>
                                                                <th class="w-32 px-3 py-3 font-bold">Day</th>
                                                                <th class="w-36 px-3 py-3 font-bold">Time</th>
                                                                <th class="w-32 px-3 py-3 font-bold">Room</th>
                                                                <th class="w-40 px-3 py-3 text-right font-bold">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($class->classSchedules as $schedule)
                                                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                                                    <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                                                    <td class="px-3 py-2 font-semibold text-slate-700">{{ $schedule->id }}</td>
                                                                    <td class="px-3 py-2 font-bold text-slate-950">{{ $schedule->subject?->name ?? 'Deleted subject' }}</td>
                                                                    <td class="px-3 py-2 font-semibold text-slate-700">{{ $schedule->day }}</td>
                                                                    <td class="px-3 py-2 font-semibold text-slate-700">{{ substr((string) $schedule->time_from, 0, 5) }} - {{ substr((string) $schedule->time_to, 0, 5) }}</td>
                                                                    <td class="px-3 py-2 font-semibold text-slate-700">{{ $schedule->room?->name ?? 'Deleted room' }}</td>
                                                                    <td class="px-3 py-2">
                                                                        <div class="flex justify-end gap-2">
                                                                            <button type="button" onclick="document.getElementById('edit-schedule-{{ $schedule->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                                                Edit
                                                                            </button>
                                                                            <button type="button" onclick="document.getElementById('delete-schedule-{{ $schedule->id }}').showModal()" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                                                Delete
                                                                            </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="7" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">
                                                                        No schedules found.
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </dialog>

                                        <dialog id="add-schedule-{{ $class->id }}" class="m-auto w-full max-w-lg rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('academic.schedule-load.class-schedule.schedules.store', $class) }}" class="p-4">
                                                @csrf
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Add Schedule</h2>
                                                    <button type="button" onclick="document.getElementById('add-schedule-{{ $class->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-bold text-slate-800" for="schedule-subject-name-{{ $class->id }}">Subject</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="schedule-subject-id-{{ $class->id }}" type="hidden" name="subject_id">
                                                            <input id="schedule-subject-name-{{ $class->id }}" type="text" placeholder="Select subject" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-schedule-picker data-picker-type="subject" data-target-id="schedule-subject-id-{{ $class->id }}" data-target-name="schedule-subject-name-{{ $class->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select subject">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="schedule-day-{{ $class->id }}">Day</label>
                                                        <input id="schedule-day-{{ $class->id }}" type="text" name="day" placeholder="eg MWF" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="schedule-room-name-{{ $class->id }}">Room</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="schedule-room-id-{{ $class->id }}" type="hidden" name="room_id">
                                                            <input id="schedule-room-name-{{ $class->id }}" type="text" placeholder="Select room" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-schedule-picker data-picker-type="room" data-target-id="schedule-room-id-{{ $class->id }}" data-target-name="schedule-room-name-{{ $class->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select room">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="schedule-from-{{ $class->id }}">Start Time</label>
                                                        <input id="schedule-from-{{ $class->id }}" type="time" name="time_from" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="schedule-to-{{ $class->id }}">End Time</label>
                                                        <input id="schedule-to-{{ $class->id }}" type="time" name="time_to" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                </div>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('add-schedule-{{ $class->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        @foreach ($class->classSchedules as $schedule)
                                            <dialog id="edit-schedule-{{ $schedule->id }}" class="m-auto w-full max-w-lg rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                                <form method="POST" action="{{ route('academic.schedule-load.class-schedule.schedules.update', $schedule) }}" class="p-4">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="relative text-center">
                                                        <h2 class="text-xl font-black">Edit Schedule</h2>
                                                        <button type="button" onclick="document.getElementById('edit-schedule-{{ $schedule->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                            &times;
                                                        </button>
                                                    </div>

                                                    <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
                                                        <div class="md:col-span-2">
                                                            <label class="block text-sm font-bold text-slate-800" for="edit-schedule-subject-name-{{ $schedule->id }}">Subject</label>
                                                            <div class="mt-1.5 flex gap-2">
                                                                <input id="edit-schedule-subject-id-{{ $schedule->id }}" type="hidden" name="subject_id" value="{{ $schedule->subject_id }}">
                                                                <input id="edit-schedule-subject-name-{{ $schedule->id }}" type="text" value="{{ $schedule->subject?->name }}" placeholder="Select subject" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                                <button type="button" data-schedule-picker data-picker-type="subject" data-target-id="edit-schedule-subject-id-{{ $schedule->id }}" data-target-name="edit-schedule-subject-name-{{ $schedule->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select subject">
                                                                    <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-bold text-slate-800" for="edit-schedule-day-{{ $schedule->id }}">Day</label>
                                                            <input id="edit-schedule-day-{{ $schedule->id }}" type="text" name="day" value="{{ $schedule->day }}" placeholder="eg MWF" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-bold text-slate-800" for="edit-schedule-room-name-{{ $schedule->id }}">Room</label>
                                                            <div class="mt-1.5 flex gap-2">
                                                                <input id="edit-schedule-room-id-{{ $schedule->id }}" type="hidden" name="room_id" value="{{ $schedule->room_id }}">
                                                                <input id="edit-schedule-room-name-{{ $schedule->id }}" type="text" value="{{ $schedule->room?->name }}" placeholder="Select room" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                                <button type="button" data-schedule-picker data-picker-type="room" data-target-id="edit-schedule-room-id-{{ $schedule->id }}" data-target-name="edit-schedule-room-name-{{ $schedule->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select room">
                                                                    <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-bold text-slate-800" for="edit-schedule-from-{{ $schedule->id }}">Start Time</label>
                                                            <input id="edit-schedule-from-{{ $schedule->id }}" type="time" name="time_from" value="{{ substr((string) $schedule->time_from, 0, 5) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                        </div>
                                                        <div>
                                                            <label class="block text-sm font-bold text-slate-800" for="edit-schedule-to-{{ $schedule->id }}">End Time</label>
                                                            <input id="edit-schedule-to-{{ $schedule->id }}" type="time" name="time_to" value="{{ substr((string) $schedule->time_to, 0, 5) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                        </div>
                                                    </div>

                                                    <div class="mt-4 flex gap-2">
                                                        <button type="button" onclick="document.getElementById('edit-schedule-{{ $schedule->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                            Save
                                                        </button>
                                                    </div>
                                                </form>
                                            </dialog>

                                            <dialog id="delete-schedule-{{ $schedule->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                                <form method="POST" action="{{ route('academic.schedule-load.class-schedule.schedules.destroy', $schedule) }}" class="p-4">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="relative text-center">
                                                        <h2 class="text-xl font-black">Delete!</h2>
                                                        <button type="button" onclick="document.getElementById('delete-schedule-{{ $schedule->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                            &times;
                                                        </button>
                                                    </div>

                                                    <p class="mt-3 text-center text-sm leading-6 text-slate-600">
                                                        Are you sure you want to delete schedule <span class="font-bold text-slate-950">#{{ $schedule->id }}</span>?
                                                    </p>

                                                    <div class="mt-4 flex gap-2">
                                                        <button type="button" onclick="document.getElementById('delete-schedule-{{ $schedule->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                            Cancel
                                                        </button>
                                                        <button type="submit" class="w-full rounded-[2rem] bg-red-600 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-red-700">
                                                            Delete
                                                        </button>
                                                    </div>
                                                </form>
                                            </dialog>
                                        @endforeach

                                        <dialog id="edit-class-schedule-{{ $class->id }}" class="m-auto w-full max-w-lg rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('academic.schedule-load.class-schedule.update', $class) }}" class="p-4">
                                                @csrf
                                                @method('PUT')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Edit</h2>
                                                    <button type="button" onclick="document.getElementById('edit-class-schedule-{{ $class->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-bold text-slate-800" for="class-name-{{ $class->id }}">Class</label>
                                                        <input id="class-name-{{ $class->id }}" type="text" name="name" value="{{ old('name', $class->name) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="class-grlvl-name-{{ $class->id }}">Grade Level</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="class-grlvl-{{ $class->id }}" type="hidden" name="grlvl_id" value="{{ old('grlvl_id', $class->grlvl_id) }}">
                                                            <input id="class-grlvl-name-{{ $class->id }}" type="text" value="{{ $gradeLevels->firstWhere('id', old('grlvl_id', $class->grlvl_id))?->name }}" placeholder="Select grade level" readonly required class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-schedule-picker data-picker-type="grade-level" data-target-id="class-grlvl-{{ $class->id }}" data-target-name="class-grlvl-name-{{ $class->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select grade level">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="class-track-name-{{ $class->id }}">Track</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="class-track-{{ $class->id }}" type="hidden" name="track_id" value="{{ old('track_id', $class->track_id) }}">
                                                            <input id="class-track-name-{{ $class->id }}" type="text" value="{{ $tracks->firstWhere('id', old('track_id', $class->track_id))?->name }}" placeholder="Select track" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-schedule-picker data-picker-type="track" data-target-id="class-track-{{ $class->id }}" data-target-name="class-track-name-{{ $class->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select track">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="class-acady-name-{{ $class->id }}">Academic Year</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="class-acady-{{ $class->id }}" type="hidden" name="acady_id" value="{{ old('acady_id', $class->acady_id) }}">
                                                            <input id="class-acady-name-{{ $class->id }}" type="text" value="{{ $academicYears->firstWhere('id', old('acady_id', $class->acady_id))?->name }}" placeholder="Select academic year" readonly required class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-schedule-picker data-picker-type="academic-year" data-target-id="class-acady-{{ $class->id }}" data-target-name="class-acady-name-{{ $class->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select academic year">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="class-adviser-name-{{ $class->id }}">Adviser</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="class-adviser-{{ $class->id }}" type="hidden" name="adviser_id" value="{{ old('adviser_id', $class->adviser_id) }}">
                                                            <input id="class-adviser-name-{{ $class->id }}" type="text" value="{{ $teachers->firstWhere('id', old('adviser_id', $class->adviser_id))?->name }}" placeholder="Select adviser" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-schedule-picker data-picker-type="adviser" data-target-id="class-adviser-{{ $class->id }}" data-target-name="class-adviser-name-{{ $class->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select adviser">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('edit-class-schedule-{{ $class->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="delete-class-schedule-{{ $class->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('academic.schedule-load.class-schedule.destroy', $class) }}" class="p-4">
                                                @csrf
                                                @method('DELETE')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Delete!</h2>
                                                    <button type="button" onclick="document.getElementById('delete-class-schedule-{{ $class->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-3 text-center text-sm leading-6 text-slate-600">
                                                    Are you sure you want to delete <span class="font-bold text-slate-950">{{ $class->name }}</span>?
                                                </p>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('delete-class-schedule-{{ $class->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                        No class schedules found.
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
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-picker-row="grade-level" data-search-text="{{ strtolower($gradeLevel->id . ' ' . $gradeLevel->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $gradeLevel->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $gradeLevel->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-schedule-option="grade-level" data-option-id="{{ $gradeLevel->id }}" data-option-name="{{ $gradeLevel->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
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
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-picker-row="track" data-search-text="{{ strtolower($track->id . ' ' . $track->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $track->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $track->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-schedule-option="track" data-option-id="{{ $track->id }}" data-option-name="{{ $track->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
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
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-picker-row="academic-year" data-search-text="{{ strtolower($academicYear->id . ' ' . $academicYear->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $academicYear->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $academicYear->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-schedule-option="academic-year" data-option-id="{{ $academicYear->id }}" data-option-name="{{ $academicYear->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
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

    <dialog id="adviser-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Advisers</h2>
                <button type="button" onclick="document.getElementById('adviser-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="adviser-picker-search" type="search" placeholder="Search adviser" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

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
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-picker-row="adviser" data-search-text="{{ strtolower($teacher->id . ' ' . $teacher->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $teacher->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $teacher->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-schedule-option="adviser" data-option-id="{{ $teacher->id }}" data-option-name="{{ $teacher->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No advisers found.</td>
                            </tr>
                        @endforelse
                        <tr id="adviser-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No matching advisers found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <dialog id="subject-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Subjects</h2>
                <button type="button" onclick="document.getElementById('subject-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="subject-picker-search" type="search" placeholder="Search subject" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

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
                        @forelse ($subjects as $subject)
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-picker-row="subject" data-search-text="{{ strtolower($subject->id . ' ' . ($subject->code ?? '') . ' ' . $subject->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $subject->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $subject->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-schedule-option="subject" data-option-id="{{ $subject->id }}" data-option-name="{{ $subject->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No subjects found.</td>
                            </tr>
                        @endforelse
                        <tr id="subject-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No matching subjects found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <dialog id="room-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Rooms</h2>
                <button type="button" onclick="document.getElementById('room-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="room-picker-search" type="search" placeholder="Search room" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

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
                        @forelse ($rooms as $room)
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-picker-row="room" data-search-text="{{ strtolower($room->id . ' ' . $room->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $room->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $room->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-schedule-option="room" data-option-id="{{ $room->id }}" data-option-name="{{ $room->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No rooms found.</td>
                            </tr>
                        @endforelse
                        <tr id="room-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No matching rooms found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const openModalId = @json(session('open_modal'));
            let activePickerType = null;
            let activePickerIdInput = null;
            let activePickerNameInput = null;
            const pickerConfigs = {
                'grade-level': {
                    modal: document.getElementById('grade-level-picker-modal'),
                    search: document.getElementById('grade-level-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-picker-row="grade-level"]')),
                    noResults: document.getElementById('grade-level-picker-no-results'),
                },
                track: {
                    modal: document.getElementById('track-picker-modal'),
                    search: document.getElementById('track-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-picker-row="track"]')),
                    noResults: document.getElementById('track-picker-no-results'),
                },
                'academic-year': {
                    modal: document.getElementById('academic-year-picker-modal'),
                    search: document.getElementById('academic-year-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-picker-row="academic-year"]')),
                    noResults: document.getElementById('academic-year-picker-no-results'),
                },
                adviser: {
                    modal: document.getElementById('adviser-picker-modal'),
                    search: document.getElementById('adviser-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-picker-row="adviser"]')),
                    noResults: document.getElementById('adviser-picker-no-results'),
                },
                subject: {
                    modal: document.getElementById('subject-picker-modal'),
                    search: document.getElementById('subject-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-picker-row="subject"]')),
                    noResults: document.getElementById('subject-picker-no-results'),
                },
                room: {
                    modal: document.getElementById('room-picker-modal'),
                    search: document.getElementById('room-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-picker-row="room"]')),
                    noResults: document.getElementById('room-picker-no-results'),
                },
            };

            document.querySelectorAll('dialog').forEach((dialog) => {
                dialog.addEventListener('click', (event) => {
                    if (event.target === dialog) {
                        dialog.close();
                    }
                });
            });

            document.querySelectorAll('[data-schedule-picker]').forEach((button) => {
                button.addEventListener('click', () => {
                    const config = pickerConfigs[button.dataset.pickerType];

                    if (! config?.modal) {
                        return;
                    }

                    activePickerType = button.dataset.pickerType;
                    activePickerIdInput = document.getElementById(button.dataset.targetId);
                    activePickerNameInput = document.getElementById(button.dataset.targetName);

                    if (config.search) {
                        config.search.value = '';
                    }

                    config.rows.forEach((row) => row.classList.remove('hidden'));
                    config.noResults?.classList.add('hidden');
                    config.modal.showModal();
                    config.search?.focus();
                });
            });

            Object.values(pickerConfigs).forEach((config) => {
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

            document.querySelectorAll('[data-select-schedule-option]').forEach((button) => {
                button.addEventListener('click', () => {
                    if (activePickerType !== button.dataset.selectScheduleOption) {
                        return;
                    }

                    if (activePickerIdInput && activePickerNameInput) {
                        activePickerIdInput.value = button.dataset.optionId;
                        activePickerNameInput.value = button.dataset.optionName;
                    }

                    pickerConfigs[button.dataset.selectScheduleOption]?.modal?.close();
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
