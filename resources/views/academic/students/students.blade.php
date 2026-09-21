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
                                <th class="px-4 py-3 font-bold">Student No.</th>
                                <th class="px-4 py-3 font-bold">Grade Level</th>
                                <th class="px-4 py-3 font-bold">Class</th>
                                <th class="px-4 py-3 font-bold">Portal Account</th>
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
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $student->student?->student_number ?? '-' }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $student->gradeLevel?->name ?? '-' }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $student->schoolClass?->name ?? '-' }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">@if($student->student?->portalAccount)<span class="font-bold text-emerald-700">LINKED</span> · {{ $student->student->portalAccount->status }}@else<span class="font-bold text-amber-700">NOT LINKED</span>@endif</td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('edit-student-{{ $student->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                Edit
                                            </button>
                                            @if($student->student?->portalAccount)
                                                <a href="{{ route('configuration.accounts.registrations.show', ['type'=>'student','id'=>$student->student->portalAccount->id]) }}" class="rounded-[2rem] border border-emerald-200 px-3 py-1.5 text-xs font-bold text-emerald-700">View Account</a>
                                            @else
                                                <button type="button" onclick="document.getElementById('link-account-{{ $student->id }}').showModal()" class="rounded-[2rem] border border-amber-200 px-3 py-1.5 text-xs font-bold text-amber-700">Link Portal Account</button>
                                            @endif
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
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-bold text-slate-800" for="student-name-{{ $student->id }}">Student</label>
                                                        <input id="student-name-{{ $student->id }}" type="text" name="name" value="{{ old('name', $student->name) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-bold text-slate-800" for="student-lrn-{{ $student->id }}">LRN</label>
                                                        <input id="student-lrn-{{ $student->id }}" type="text" name="lrn" value="{{ old('lrn', $student->lrn) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="student-gender-{{ $student->id }}">Gender</label>
                                                        <select id="student-gender-{{ $student->id }}" name="gender" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <option value="">Select gender</option>
                                                            <option value="Male" @selected(old('gender', $student->gender) === 'Male')>Male</option>
                                                            <option value="Female" @selected(old('gender', $student->gender) === 'Female')>Female</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="student-birthdate-{{ $student->id }}">Birthdate</label>
                                                        <input id="student-birthdate-{{ $student->id }}" type="date" name="birthdate" value="{{ old('birthdate', $student->birthdate) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="student-acady-{{ $student->id }}">Academic Year</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="student-acady-{{ $student->id }}" type="hidden" name="acady_id" value="{{ old('acady_id', $student->acady_id) }}">
                                                            <input id="student-acady-name-{{ $student->id }}" type="text" value="{{ $academicYears->firstWhere('id', (int) old('acady_id', $student->acady_id))?->name }}" placeholder="Select academic year" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-academic-student-picker data-picker-type="academic-year" data-target-id="student-acady-{{ $student->id }}" data-target-name="student-acady-name-{{ $student->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select academic year">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="student-grlvl-{{ $student->id }}">Grade Level</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="student-grlvl-{{ $student->id }}" type="hidden" name="grlvl_id" value="{{ old('grlvl_id', $student->grlvl_id) }}">
                                                            <input id="student-grlvl-name-{{ $student->id }}" type="text" value="{{ $gradeLevels->firstWhere('id', (int) old('grlvl_id', $student->grlvl_id))?->name }}" placeholder="Select grade level" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-academic-student-picker data-picker-type="grade-level" data-target-id="student-grlvl-{{ $student->id }}" data-target-name="student-grlvl-name-{{ $student->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select grade level">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="student-class-{{ $student->id }}">Class</label>
                                                        <div class="mt-1.5 flex gap-2">
                                                            <input id="student-class-{{ $student->id }}" type="hidden" name="class_id" value="{{ old('class_id', $student->class_id) }}">
                                                            <input id="student-class-name-{{ $student->id }}" type="text" value="{{ $classes->firstWhere('id', (int) old('class_id', $student->class_id))?->name }}" placeholder="Select class" readonly class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                            <button type="button" data-academic-student-picker data-picker-type="class" data-target-id="student-class-{{ $student->id }}" data-target-name="student-class-name-{{ $student->id }}" class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-300 bg-white transition hover:scale-105 hover:bg-blue-50" aria-label="Select class">
                                                                <img src="{{ asset('icons/magnifying-glass.png') }}" alt="" class="h-5 w-5">
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-sm font-bold text-slate-800" for="student-contact-{{ $student->id }}">Contact</label>
                                                        <input id="student-contact-{{ $student->id }}" type="text" name="contact" value="{{ old('contact', $student->contact) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                    <div class="md:col-span-2">
                                                        <label class="block text-sm font-bold text-slate-800" for="student-address-{{ $student->id }}">Address</label>
                                                        <input id="student-address-{{ $student->id }}" type="text" name="address" value="{{ old('address', $student->address) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">
                                                    </div>
                                                </div>

                                                <div class="mt-4 rounded-lg border border-slate-200 bg-slate-50 p-3"><p class="text-xs font-black uppercase text-slate-500">Portal Account</p>@if($student->student?->portalAccount)<p class="mt-2 font-bold text-emerald-700">LINKED · {{ $student->student->portalAccount->status }}</p><p class="text-sm">{{ $student->student->portalAccount->name ?: $student->student->portalAccount->username }}</p><p class="text-sm">Username: {{ $student->student->portalAccount->username }}</p><a class="mt-2 inline-block text-sm font-bold text-blue-700" href="{{ route('configuration.accounts.registrations.show', ['type'=>'student','id'=>$student->student->portalAccount->id]) }}">View Account</a>@else<p class="mt-2 font-bold text-amber-700">NOT LINKED</p><button type="button" onclick="document.getElementById('edit-student-{{ $student->id }}').close();document.getElementById('link-account-{{ $student->id }}').showModal()" class="mt-2 text-sm font-bold text-blue-700">Link Portal Account</button>@endif</div>

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

                                        @unless($student->student?->portalAccount)
                                        <dialog id="link-account-{{ $student->id }}" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <div class="max-h-[85vh] overflow-y-auto p-4"><div class="relative text-center"><h2 class="text-xl font-black">Link Portal Account</h2><button type="button" onclick="document.getElementById('link-account-{{ $student->id }}').close()" class="absolute right-0 top-0 px-3 py-1 text-2xl">&times;</button></div>
                                                <div class="mt-4 rounded-lg bg-slate-50 p-3"><strong>{{ $student->name }}</strong><p>{{ $student->gradeLevel?->name }} / {{ $student->schoolClass?->name }} / {{ $student->academicYear?->name }}</p><p>Student No: {{ $student->student?->student_number }}</p></div>
                                                <input type="search" placeholder="Search name or username" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2" oninput="this.closest('dialog').querySelectorAll('[data-account-option]').forEach(row=>row.hidden=!row.dataset.accountOption.includes(this.value.toLowerCase()))">
                                                <div class="mt-3 space-y-2">@forelse($availableAccounts as $account)<form data-account-option="{{ strtolower(($account->name ?? '').' '.$account->username) }}" method="POST" action="{{ route('configuration.accounts.registrations.students.link',$account) }}" class="flex items-center justify-between gap-3 rounded-lg border p-3">@csrf<input type="hidden" name="student_id" value="{{ $student->student_id }}"><input type="hidden" name="confirm" value="1"><div><strong>{{ $account->name ?: $account->username }}</strong><p class="text-sm">{{ $account->username }} · {{ $account->status }}</p></div><button class="rounded-[2rem] bg-blue-700 px-3 py-1.5 text-sm font-bold text-white">Confirm &amp; Link</button></form>@empty<p class="p-4 text-center">No eligible unlinked portal accounts.</p>@endforelse</div>
                                            </div>
                                        </dialog>
                                        @endunless

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
                                    <td colspan="6" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
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

    <dialog id="academic-student-academic-year-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Academic Years</h2>
                <button type="button" onclick="document.getElementById('academic-student-academic-year-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="academic-student-academic-year-picker-search" type="search" placeholder="Search academic year" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

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
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-academic-student-picker-row="academic-year" data-search-text="{{ strtolower($academicYear->id . ' ' . $academicYear->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $academicYear->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $academicYear->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-academic-student-option="academic-year" data-option-id="{{ $academicYear->id }}" data-option-name="{{ $academicYear->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No academic years found.</td>
                            </tr>
                        @endforelse
                        <tr id="academic-student-academic-year-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No matching academic years found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <dialog id="academic-student-grade-level-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Grade Levels</h2>
                <button type="button" onclick="document.getElementById('academic-student-grade-level-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="academic-student-grade-level-picker-search" type="search" placeholder="Search grade level" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

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
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-academic-student-picker-row="grade-level" data-search-text="{{ strtolower($gradeLevel->id . ' ' . $gradeLevel->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $gradeLevel->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $gradeLevel->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-academic-student-option="grade-level" data-option-id="{{ $gradeLevel->id }}" data-option-name="{{ $gradeLevel->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No grade levels found.</td>
                            </tr>
                        @endforelse
                        <tr id="academic-student-grade-level-picker-no-results" class="hidden">
                            <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No matching grade levels found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </dialog>

    <dialog id="academic-student-class-picker-modal" class="m-auto w-full max-w-xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
        <div class="p-4">
            <div class="relative text-center">
                <h2 class="text-xl font-black">Classes</h2>
                <button type="button" onclick="document.getElementById('academic-student-class-picker-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                    &times;
                </button>
            </div>

            <input id="academic-student-class-picker-search" type="search" placeholder="Search class" class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

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
                            <tr class="border-b border-slate-200 hover:bg-slate-50" data-academic-student-picker-row="class" data-search-text="{{ strtolower($class->id . ' ' . $class->name) }}">
                                <td class="px-3 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-3 py-2 font-semibold text-slate-700">{{ $class->id }}</td>
                                <td class="px-3 py-2 font-bold text-slate-950">{{ $class->name }}</td>
                                <td class="px-3 py-2 text-right">
                                    <button type="button" data-select-academic-student-option="class" data-option-id="{{ $class->id }}" data-option-name="{{ $class->name }}" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                        Select
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-3 py-8 text-center text-sm font-semibold text-slate-500">No classes found.</td>
                            </tr>
                        @endforelse
                        <tr id="academic-student-class-picker-no-results" class="hidden">
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
                    modal: document.getElementById('academic-student-academic-year-picker-modal'),
                    search: document.getElementById('academic-student-academic-year-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-academic-student-picker-row="academic-year"]')),
                    noResults: document.getElementById('academic-student-academic-year-picker-no-results'),
                },
                'grade-level': {
                    modal: document.getElementById('academic-student-grade-level-picker-modal'),
                    search: document.getElementById('academic-student-grade-level-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-academic-student-picker-row="grade-level"]')),
                    noResults: document.getElementById('academic-student-grade-level-picker-no-results'),
                },
                class: {
                    modal: document.getElementById('academic-student-class-picker-modal'),
                    search: document.getElementById('academic-student-class-picker-search'),
                    rows: Array.from(document.querySelectorAll('[data-academic-student-picker-row="class"]')),
                    noResults: document.getElementById('academic-student-class-picker-no-results'),
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

            document.querySelectorAll('[data-academic-student-picker]').forEach((button) => {
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

            document.querySelectorAll('[data-select-academic-student-option]').forEach((button) => {
                button.addEventListener('click', () => {
                    if (activePickerType !== button.dataset.selectAcademicStudentOption) {
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
