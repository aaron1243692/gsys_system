@extends('layouts.app')

@section('title', 'Pre-enlistment')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Students</p>
            <h1 class="text-3xl font-black text-slate-950">Pre-enlistment</h1>
        </section>

        @if (session('success') || $errors->any())
            @php
                $isSuccess = session('success') !== null;
                $feedbackTitle = $isSuccess ? 'Success!' : 'Failed!';
                $feedbackMessage = session('success') ?? $errors->first();
                $feedbackColor = $isSuccess ? 'blue' : 'red';
            @endphp

            <div id="pre-enlistment-feedback-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-5 backdrop-blur-sm">
                <div class="w-full max-w-sm rounded-lg border border-slate-200 bg-white p-4 text-center text-slate-950 shadow-2xl">
                    <div class="relative">
                        <h2 class="text-xl font-black {{ $feedbackColor === 'blue' ? 'text-blue-700' : 'text-red-600' }}">{{ $feedbackTitle }}</h2>
                        <button type="button" onclick="document.getElementById('pre-enlistment-feedback-modal').remove()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                            &times;
                        </button>
                    </div>

                    <p class="mx-auto mt-3 max-w-xs text-center text-sm leading-6 text-slate-600">{{ $feedbackMessage }}</p>

                    <button type="button" onclick="document.getElementById('pre-enlistment-feedback-modal').remove()" class="mt-4 w-full rounded-[2rem] {{ $feedbackColor === 'blue' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-bold text-white transition hover:scale-105">
                        OK
                    </button>
                </div>
            </div>
        @endif

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <form method="GET" action="{{ route('academic.students.pre-enlistment') }}" class="mb-4 flex w-full gap-2 md:max-w-md">
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
                                <th class="w-52 px-4 py-3 text-right font-bold">Action</th>
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
                                            <button type="button" onclick="document.getElementById('view-pre-enlistment-{{ $student->id }}').showModal()" class="rounded-[2rem] border border-emerald-200 px-3 py-1.5 text-xs font-bold text-emerald-700 transition hover:scale-110 hover:bg-emerald-50">
                                                Admit
                                            </button>
                                            <button type="button" onclick="document.getElementById('edit-pre-enlistment-{{ $student->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                Edit
                                            </button>
                                            <button type="button" onclick="document.getElementById('delete-pre-enlistment-{{ $student->id }}').showModal()" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </div>

                                        <dialog id="view-pre-enlistment-{{ $student->id }}" class="m-auto w-full max-w-lg rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('academic.students.admit', $student) }}" class="scrollbar-none max-h-[85vh] overflow-y-auto p-4">
                                                @csrf

                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Admit</h2>
                                                    <button type="button" onclick="document.getElementById('view-pre-enlistment-{{ $student->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-bold text-slate-800" for="admit-pre-enlistment-name-{{ $student->id }}">Student</label>
                                                        <input id="admit-pre-enlistment-name-{{ $student->id }}" type="text" name="name" value="{{ old('name', $student->name) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-bold text-slate-800" for="admit-pre-enlistment-lrn-{{ $student->id }}">LRN</label>
                                                        <input id="admit-pre-enlistment-lrn-{{ $student->id }}" type="text" name="lrn" value="{{ old('lrn', $student->lrn) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="admit-pre-enlistment-gender-{{ $student->id }}">Gender</label>
                                                        <select id="admit-pre-enlistment-gender-{{ $student->id }}" name="gender" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <option value="">Select gender</option>
                                                            <option value="Male" @selected(old('gender', $student->gender) === 'Male')>Male</option>
                                                            <option value="Female" @selected(old('gender', $student->gender) === 'Female')>Female</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="admit-pre-enlistment-birthdate-{{ $student->id }}">Birthdate</label>
                                                        <input id="admit-pre-enlistment-birthdate-{{ $student->id }}" type="date" name="birthdate" value="{{ old('birthdate', $student->birthdate) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="admit-pre-enlistment-acady-{{ $student->id }}">Academic Year</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="admit-pre-enlistment-acady-{{ $student->id }}" type="hidden" name="acady_id" value="{{ old('acady_id', $student->acady_id) }}">
                                                            <input id="admit-pre-enlistment-acady-name-{{ $student->id }}" type="text" value="{{ $academicYears->firstWhere('id', (int) old('acady_id', $student->acady_id))?->name }}" placeholder="Select academic year" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-student-picker data-picker-type="academic-year" data-target-id="admit-pre-enlistment-acady-{{ $student->id }}" data-target-name="admit-pre-enlistment-acady-name-{{ $student->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select academic year">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="admit-pre-enlistment-grlvl-{{ $student->id }}">Grade Level</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="admit-pre-enlistment-grlvl-{{ $student->id }}" type="hidden" name="grlvl_id" value="{{ old('grlvl_id', $student->grlvl_id) }}">
                                                            <input id="admit-pre-enlistment-grlvl-name-{{ $student->id }}" type="text" value="{{ $gradeLevels->firstWhere('id', (int) old('grlvl_id', $student->grlvl_id))?->name }}" placeholder="Select grade level" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-student-picker data-picker-type="grade-level" data-target-id="admit-pre-enlistment-grlvl-{{ $student->id }}" data-target-name="admit-pre-enlistment-grlvl-name-{{ $student->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select grade level">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="admit-pre-enlistment-class-{{ $student->id }}">Class</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="admit-pre-enlistment-class-{{ $student->id }}" type="hidden" name="class_id" value="{{ old('class_id', $student->class_id) }}">
                                                            <input id="admit-pre-enlistment-class-name-{{ $student->id }}" type="text" value="{{ $classes->firstWhere('id', (int) old('class_id', $student->class_id))?->name }}" placeholder="Select class" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-student-picker data-picker-type="class" data-target-id="admit-pre-enlistment-class-{{ $student->id }}" data-target-name="admit-pre-enlistment-class-name-{{ $student->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select class">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="admit-pre-enlistment-contact-{{ $student->id }}">Contact</label>
                                                        <input id="admit-pre-enlistment-contact-{{ $student->id }}" type="text" name="contact" value="{{ old('contact', $student->contact) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-bold text-slate-800" for="admit-pre-enlistment-address-{{ $student->id }}">Address</label>
                                                        <input id="admit-pre-enlistment-address-{{ $student->id }}" type="text" name="address" value="{{ old('address', $student->address) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                </div>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('view-pre-enlistment-{{ $student->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-emerald-600 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-emerald-700">
                                                        Admit
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="edit-pre-enlistment-{{ $student->id }}" class="m-auto w-full max-w-lg rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('academic.students.update', $student) }}" class="scrollbar-none max-h-[85vh] overflow-y-auto p-4">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="redirect_to" value="pre-enlistment">

                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Edit</h2>
                                                    <button type="button" onclick="document.getElementById('edit-pre-enlistment-{{ $student->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <div class="mt-4 grid grid-cols-1 gap-3 md:grid-cols-2">
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-bold text-slate-800" for="pre-enlistment-name-{{ $student->id }}">Student</label>
                                                        <input id="pre-enlistment-name-{{ $student->id }}" type="text" name="name" value="{{ old('name', $student->name) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-bold text-slate-800" for="pre-enlistment-lrn-{{ $student->id }}">LRN</label>
                                                        <input id="pre-enlistment-lrn-{{ $student->id }}" type="text" name="lrn" value="{{ old('lrn', $student->lrn) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="pre-enlistment-gender-{{ $student->id }}">Gender</label>
                                                        <select id="pre-enlistment-gender-{{ $student->id }}" name="gender" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <option value="">Select gender</option>
                                                            <option value="Male" @selected(old('gender', $student->gender) === 'Male')>Male</option>
                                                            <option value="Female" @selected(old('gender', $student->gender) === 'Female')>Female</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="pre-enlistment-birthdate-{{ $student->id }}">Birthdate</label>
                                                        <input id="pre-enlistment-birthdate-{{ $student->id }}" type="date" name="birthdate" value="{{ old('birthdate', $student->birthdate) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="pre-enlistment-acady-{{ $student->id }}">Academic Year</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="pre-enlistment-acady-{{ $student->id }}" type="hidden" name="acady_id" value="{{ old('acady_id', $student->acady_id) }}">
                                                            <input id="pre-enlistment-acady-name-{{ $student->id }}" type="text" value="{{ $academicYears->firstWhere('id', (int) old('acady_id', $student->acady_id))?->name }}" placeholder="Select academic year" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-student-picker data-picker-type="academic-year" data-target-id="pre-enlistment-acady-{{ $student->id }}" data-target-name="pre-enlistment-acady-name-{{ $student->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select academic year">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="pre-enlistment-grlvl-{{ $student->id }}">Grade Level</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="pre-enlistment-grlvl-{{ $student->id }}" type="hidden" name="grlvl_id" value="{{ old('grlvl_id', $student->grlvl_id) }}">
                                                            <input id="pre-enlistment-grlvl-name-{{ $student->id }}" type="text" value="{{ $gradeLevels->firstWhere('id', (int) old('grlvl_id', $student->grlvl_id))?->name }}" placeholder="Select grade level" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-student-picker data-picker-type="grade-level" data-target-id="pre-enlistment-grlvl-{{ $student->id }}" data-target-name="pre-enlistment-grlvl-name-{{ $student->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select grade level">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="pre-enlistment-class-{{ $student->id }}">Class</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="pre-enlistment-class-{{ $student->id }}" type="hidden" name="class_id" value="{{ old('class_id', $student->class_id) }}">
                                                            <input id="pre-enlistment-class-name-{{ $student->id }}" type="text" value="{{ $classes->firstWhere('id', (int) old('class_id', $student->class_id))?->name }}" placeholder="Select class" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-student-picker data-picker-type="class" data-target-id="pre-enlistment-class-{{ $student->id }}" data-target-name="pre-enlistment-class-name-{{ $student->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select class">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="pre-enlistment-contact-{{ $student->id }}">Contact</label>
                                                        <input id="pre-enlistment-contact-{{ $student->id }}" type="text" name="contact" value="{{ old('contact', $student->contact) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-bold text-slate-800" for="pre-enlistment-address-{{ $student->id }}">Address</label>
                                                        <input id="pre-enlistment-address-{{ $student->id }}" type="text" name="address" value="{{ old('address', $student->address) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                </div>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('edit-pre-enlistment-{{ $student->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="delete-pre-enlistment-{{ $student->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('academic.students.pre-enlistment.destroy', $student) }}" class="p-4">
                                                @csrf
                                                @method('DELETE')

                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Delete!</h2>
                                                    <button type="button" onclick="document.getElementById('delete-pre-enlistment-{{ $student->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-3 text-center text-sm leading-6 text-slate-600">
                                                    Are you sure you want to delete <span class="font-bold text-slate-950">{{ $student->name }}</span>?
                                                </p>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('delete-pre-enlistment-{{ $student->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                        No pre-enlistment records found.
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

    <dialog id="student-academic-year-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Academic Years</h2>
                <button type="button" onclick="document.getElementById('student-academic-year-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="student-academic-year-picker-search" type="search" placeholder="Search academic year" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

            <div class="mt-4 max-h-80 overflow-y-auto rounded-lg border border-slate-200">
                <table class="w-full border-collapse text-left text-sm">
                    <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                        <tr>
                            <th class="w-16 px-3 py-2 font-bold">No</th>
                            <th class="w-20 px-3 py-2 font-bold">ID</th>
                            <th class="px-3 py-2 font-bold">Academic Year</th>
                            <th class="w-24 px-3 py-2 text-right font-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($academicYears as $academicYear)
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-student-picker-row="academic-year" data-search-text="{{ strtolower($academicYear->id . ' ' . $academicYear->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $academicYear->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $academicYear->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-student-option="academic-year" data-option-id="{{ $academicYear->id }}" data-option-name="{{ $academicYear->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No academic years found.</td>
                            </tr>
                        @endforelse
                        <tr id="student-academic-year-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No matching academic years found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <dialog id="student-grade-level-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Grade Levels</h2>
                <button type="button" onclick="document.getElementById('student-grade-level-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="student-grade-level-picker-search" type="search" placeholder="Search grade level" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

            <div class="mt-4 max-h-80 overflow-y-auto rounded-lg border border-slate-200">
                <table class="w-full border-collapse text-left text-sm">
                    <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                        <tr>
                            <th class="w-16 px-3 py-2 font-bold">No</th>
                            <th class="w-20 px-3 py-2 font-bold">ID</th>
                            <th class="px-3 py-2 font-bold">Grade Level</th>
                            <th class="w-24 px-3 py-2 text-right font-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($gradeLevels as $gradeLevel)
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-student-picker-row="grade-level" data-search-text="{{ strtolower($gradeLevel->id . ' ' . $gradeLevel->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $gradeLevel->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $gradeLevel->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-student-option="grade-level" data-option-id="{{ $gradeLevel->id }}" data-option-name="{{ $gradeLevel->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No grade levels found.</td>
                            </tr>
                        @endforelse
                        <tr id="student-grade-level-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No matching grade levels found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <dialog id="student-class-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Classes</h2>
                <button type="button" onclick="document.getElementById('student-class-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="student-class-picker-search" type="search" placeholder="Search class" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

            <div class="mt-4 max-h-80 overflow-y-auto rounded-lg border border-slate-200">
                <table class="w-full border-collapse text-left text-sm">
                    <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                        <tr>
                            <th class="w-16 px-3 py-2 font-bold">No</th>
                            <th class="w-20 px-3 py-2 font-bold">ID</th>
                            <th class="px-3 py-2 font-bold">Class</th>
                            <th class="w-24 px-3 py-2 text-right font-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($classes as $class)
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-student-picker-row="class" data-search-text="{{ strtolower($class->id . ' ' . $class->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $class->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $class->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-student-option="class" data-option-id="{{ $class->id }}" data-option-name="{{ $class->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No classes found.</td>
                            </tr>
                        @endforelse
                        <tr id="student-class-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No matching classes found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let activePickerType = null;
            let activeTargetId = null;
            let activeTargetName = null;

            const pickerConfigs = {
                'academic-year': {
                    modal: document.getElementById('student-academic-year-picker-modal'),
                    search: document.getElementById('student-academic-year-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-student-picker-row="academic-year"]')),
                    noResults: document.getElementById('student-academic-year-picker-no-results'),
                },
                'grade-level': {
                    modal: document.getElementById('student-grade-level-picker-modal'),
                    search: document.getElementById('student-grade-level-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-student-picker-row="grade-level"]')),
                    noResults: document.getElementById('student-grade-level-picker-no-results'),
                },
                class: {
                    modal: document.getElementById('student-class-picker-modal'),
                    search: document.getElementById('student-class-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-student-picker-row="class"]')),
                    noResults: document.getElementById('student-class-picker-no-results'),
                },
            };

            const filterRows = (config) => {
                const term = config.search.value.trim().toLowerCase();
                let visibleCount = 0;

                config.rows.forEach((row) => {
                    const isVisible = row.dataset.searchText.includes(term);
                    row.classList.toggle('hidden', ! isVisible);
                    visibleCount += isVisible ? 1 : 0;
                });

                config.noResults?.classList.toggle('hidden', visibleCount > 0);
            };

            Object.values(pickerConfigs).forEach((config) => {
                config.search?.addEventListener('input', () => filterRows(config));
            });

            document.querySelectorAll('[data-student-picker]').forEach((button) => {
                button.addEventListener('click', () => {
                    const config = pickerConfigs[button.dataset.pickerType];

                    if (! config?.modal) {
                        return;
                    }

                    activePickerType = button.dataset.pickerType;
                    activeTargetId = button.dataset.targetId;
                    activeTargetName = button.dataset.targetName;

                    if (config.search) {
                        config.search.value = '';
                    }

                    config.rows.forEach((row) => row.classList.remove('hidden'));
                    config.noResults?.classList.add('hidden');
                    config.modal.showModal();
                    config.search?.focus();
                });
            });

            document.querySelectorAll('[data-select-student-option]').forEach((button) => {
                button.addEventListener('click', () => {
                    if (activePickerType !== button.dataset.selectStudentOption) {
                        return;
                    }

                    document.getElementById(activeTargetId).value = button.dataset.optionId;
                    document.getElementById(activeTargetName).value = button.dataset.optionName;
                    pickerConfigs[activePickerType]?.modal?.close();
                });
            });
        });
    </script>
@endsection
