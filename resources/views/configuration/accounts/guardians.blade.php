@extends('layouts.app')

@section('title', 'Guardians')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Accounts</p>
            <h1 class="text-3xl font-black text-slate-950">Guardians</h1>
        </section>

        @if (session('success') || $errors->any())
            @php
                $isSuccess = session('success') !== null;
                $feedbackTitle = $isSuccess ? 'Success!' : 'Failed!';
                $feedbackMessage = session('success') ?? $errors->first();
                $feedbackColor = $isSuccess ? 'blue' : 'red';
            @endphp

            <div id="guardian-feedback-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-5 backdrop-blur-sm">
                <div class="w-full max-w-sm rounded-lg border border-slate-200 bg-white p-4 text-center text-slate-950 shadow-2xl">
                    <div class="relative">
                        <h2 class="text-xl font-black {{ $feedbackColor === 'blue' ? 'text-blue-700' : 'text-red-600' }}">{{ $feedbackTitle }}</h2>
                        <button type="button" onclick="document.getElementById('guardian-feedback-modal').remove()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                            &times;
                        </button>
                    </div>

                    <p class="mx-auto mt-3 max-w-xs text-center text-sm leading-6 text-slate-600">{{ $feedbackMessage }}</p>

                    <button type="button" onclick="document.getElementById('guardian-feedback-modal').remove()" class="mt-4 w-full rounded-[2rem] {{ $feedbackColor === 'blue' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-bold text-white transition hover:scale-105">
                        OK
                    </button>
                </div>
            </div>
        @endif

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <form method="GET" action="{{ route('configuration.accounts.guardians') }}" class="flex w-full gap-2 md:max-w-md">
                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search guardian"
                            onchange="this.form.submit()"
                            onsearch="this.form.submit()"
                            class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >
                    </form>

                    <button
                        type="button"
                        onclick="document.getElementById('add-guardian-modal').showModal()"
                        class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800 md:ml-auto"
                        style="border-radius: 2rem;"
                    >
                        Add
                    </button>
                </div>

                <dialog id="add-guardian-modal" class="guardian-scroll-modal m-auto max-h-[90vh] w-full max-w-sm overflow-y-auto rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                    <form method="POST" action="{{ route('configuration.accounts.guardians.store') }}" class="p-4">
                        @csrf
                        <div class="relative text-center">
                            <h2 class="text-xl font-black">Add</h2>
                            <button type="button" onclick="document.getElementById('add-guardian-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                &times;
                            </button>
                        </div>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-guardian-name">Name</label>
                        <input id="new-guardian-name" type="text" name="name" value="{{ old('name') }}" placeholder="Example: Juan Dela Cruz" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-guardian-email">Email</label>
                        <input id="new-guardian-email" type="email" name="email" value="{{ old('email') }}" placeholder="guardian@example.com" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-guardian-username">Username</label>
                        <input id="new-guardian-username" type="text" name="username" value="{{ old('username') }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-guardian-password">Password</label>
                        <input id="new-guardian-password" type="password" name="password" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-guardian-contact">Contact</label>
                        <input id="new-guardian-contact" type="text" name="contact" value="{{ old('contact') }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-guardian-address">Address</label>
                        <input id="new-guardian-address" type="text" name="address" value="{{ old('address') }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <div class="mt-4 flex gap-2">
                            <button type="button" onclick="document.getElementById('add-guardian-modal').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                <th class="px-4 py-3 font-bold">Email</th>
                                <th class="w-80 px-4 py-3 text-right font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($guardians as $guardian)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $guardians->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $guardian->id }}</td>
                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $guardian->name ?? $guardian->username }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $guardian->email ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('childs-guardian-{{ $guardian->id }}').showModal()" class="rounded-[2rem] border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 transition hover:scale-110 hover:bg-slate-50">
                                                Childs
                                            </button>
                                            <button type="button" onclick="document.getElementById('edit-guardian-{{ $guardian->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                Edit
                                            </button>
                                            <button type="button" onclick="document.getElementById('reset-guardian-{{ $guardian->id }}').showModal()" class="rounded-[2rem] border border-amber-200 px-3 py-1.5 text-xs font-bold text-amber-700 transition hover:scale-110 hover:bg-amber-50">
                                                Reset PW
                                            </button>
                                            <button type="button" onclick="document.getElementById('delete-guardian-{{ $guardian->id }}').showModal()" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </div>

                                        <dialog id="childs-guardian-{{ $guardian->id }}" class="m-auto w-full max-w-2xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <div class="p-4">
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Childs</h2>
                                                    <button type="button" onclick="document.getElementById('childs-guardian-{{ $guardian->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-2 text-center text-sm font-semibold text-slate-500">{{ $guardian->name ?? $guardian->username }}</p>

                                                <div class="mt-4 flex justify-end">
                                                    <button type="button" onclick="document.getElementById('add-child-guardian-{{ $guardian->id }}').showModal()" class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Add
                                                    </button>
                                                </div>

                                                <div class="mt-4 overflow-x-auto rounded-lg border border-slate-200">
                                                    <table class="w-full border-collapse text-left text-sm">
                                                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                                                            <tr>
                                                                <th class="w-20 px-4 py-3 font-bold">No</th>
                                                                <th class="w-24 px-4 py-3 font-bold">ID</th>
                                                                <th class="px-4 py-3 font-bold">Name</th>
                                                                <th class="w-32 px-4 py-3 text-right font-bold">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($guardian->children as $child)
                                                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $child->student?->id ?? $child->student_id }}</td>
                                                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $child->student?->info?->name ?? $child->student?->username ?? 'Deleted student' }}</td>
                                                                    <td class="px-4 py-2">
                                                                        <form method="POST" action="{{ route('configuration.accounts.guardians.childs.destroy', $child) }}" class="flex justify-end">
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
                                                                    <td colspan="4" class="px-4 py-8 text-center text-sm font-semibold text-slate-500">
                                                                        No childs found.
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="mt-4 flex justify-end">
                                                    <button type="button" onclick="document.getElementById('childs-guardian-{{ $guardian->id }}').close()" class="rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </dialog>

                                        <dialog id="add-child-guardian-{{ $guardian->id }}" class="m-auto w-full max-w-2xl rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <div class="p-4">
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Add Child</h2>
                                                    <button type="button" onclick="document.getElementById('add-child-guardian-{{ $guardian->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                @php
                                                    $assignedStudentIds = $guardian->children->pluck('student_id')->all();
                                                    $availableStudents = $students->reject(fn ($student) => in_array($student->id, $assignedStudentIds, true));
                                                @endphp

                                                <input
                                                    type="search"
                                                    placeholder="Search student"
                                                    data-child-search="add-child-guardian-{{ $guardian->id }}"
                                                    class="mt-4 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                                >

                                                <div class="mt-4 overflow-x-auto rounded-lg border border-slate-200">
                                                    <table class="w-full border-collapse text-left text-sm">
                                                        <thead class="bg-blue-700 text-xs uppercase tracking-wider text-white">
                                                            <tr>
                                                                <th class="w-20 px-4 py-3 font-bold">No</th>
                                                                <th class="w-24 px-4 py-3 font-bold">ID</th>
                                                                <th class="px-4 py-3 font-bold">Name</th>
                                                                <th class="w-32 px-4 py-3 text-right font-bold">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse ($availableStudents as $student)
                                                                @php
                                                                    $studentName = $student->info?->name ?? $student->username;
                                                                @endphp
                                                                <tr class="border-b border-slate-200 hover:bg-slate-50" data-child-row="add-child-guardian-{{ $guardian->id }}" data-child-text="{{ strtolower($student->id . ' ' . $studentName) }}">
                                                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $loop->iteration }}</td>
                                                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $student->id }}</td>
                                                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $studentName }}</td>
                                                                    <td class="px-4 py-2">
                                                                        <form method="POST" action="{{ route('configuration.accounts.guardians.childs.store', $guardian) }}" class="flex justify-end">
                                                                            @csrf
                                                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                                            <button type="submit" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                                                Select
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="4" class="px-4 py-8 text-center text-sm font-semibold text-slate-500">
                                                                        No students available.
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="mt-4 flex justify-end">
                                                    <button type="button" onclick="document.getElementById('add-child-guardian-{{ $guardian->id }}').close()" class="rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </dialog>

                                        <dialog id="edit-guardian-{{ $guardian->id }}" class="guardian-scroll-modal m-auto max-h-[90vh] w-full max-w-sm overflow-y-auto rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.accounts.guardians.update', $guardian) }}" class="p-4">
                                                @csrf
                                                @method('PUT')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Edit</h2>
                                                    <button type="button" onclick="document.getElementById('edit-guardian-{{ $guardian->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="guardian-name-{{ $guardian->id }}">Name</label>
                                                <input id="guardian-name-{{ $guardian->id }}" type="text" name="name" value="{{ old('name', $guardian->name) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="guardian-email-{{ $guardian->id }}">Email</label>
                                                <input id="guardian-email-{{ $guardian->id }}" type="email" name="email" value="{{ old('email', $guardian->email) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="guardian-username-{{ $guardian->id }}">Username</label>
                                                <input id="guardian-username-{{ $guardian->id }}" type="text" name="username" value="{{ old('username', $guardian->username) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="guardian-contact-{{ $guardian->id }}">Contact</label>
                                                <input id="guardian-contact-{{ $guardian->id }}" type="text" name="contact" value="{{ old('contact', $guardian->contact) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="guardian-address-{{ $guardian->id }}">Address</label>
                                                <input id="guardian-address-{{ $guardian->id }}" type="text" name="address" value="{{ old('address', $guardian->address) }}" class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('edit-guardian-{{ $guardian->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="reset-guardian-{{ $guardian->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.accounts.guardians.reset-password', $guardian) }}" class="p-4">
                                                @csrf
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Reset PW</h2>
                                                    <button type="button" onclick="document.getElementById('reset-guardian-{{ $guardian->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-3 text-center text-sm leading-6 text-slate-600">
                                                    Reset password for <span class="font-bold text-slate-950">{{ $guardian->name ?? $guardian->username }}</span>?
                                                </p>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="guardian-reset-password-{{ $guardian->id }}">New Password</label>
                                                <input id="guardian-reset-password-{{ $guardian->id }}" type="password" name="password" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('reset-guardian-{{ $guardian->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-amber-600 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-amber-700">
                                                        Reset PW
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="delete-guardian-{{ $guardian->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.accounts.guardians.destroy', $guardian) }}" class="p-4">
                                                @csrf
                                                @method('DELETE')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Delete!</h2>
                                                    <button type="button" onclick="document.getElementById('delete-guardian-{{ $guardian->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-3 text-center text-sm leading-6 text-slate-600">
                                                    Are you sure you want to delete <span class="font-bold text-slate-950">{{ $guardian->name ?? $guardian->username }}</span>?
                                                </p>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('delete-guardian-{{ $guardian->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                        No guardians found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($guardians->hasPages())
                    <div class="mt-4 flex flex-col gap-3 border-t border-slate-100 pt-3 md:flex-row md:items-center md:justify-between">
                        <p class="text-sm font-semibold text-slate-500">
                            Showing {{ $guardians->firstItem() }} to {{ $guardians->lastItem() }} of {{ $guardians->total() }}
                        </p>

                        <nav class="flex items-center gap-1" aria-label="Pagination">
                            @if ($guardians->onFirstPage())
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&lt;</span>
                            @else
                                <a href="{{ $guardians->previousPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&lt;</a>
                            @endif

                            @foreach ($guardians->getUrlRange(1, $guardians->lastPage()) as $page => $url)
                                @if ($page === $guardians->currentPage())
                                    <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full bg-blue-700 px-3 text-sm font-black text-white shadow-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-blue-50 hover:text-blue-700">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($guardians->hasMorePages())
                                <a href="{{ $guardians->nextPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&gt;</a>
                            @else
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&gt;</span>
                            @endif
                        </nav>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <style>
        .guardian-scroll-modal {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .guardian-scroll-modal::-webkit-scrollbar {
            display: none;
        }
    </style>

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

            document.querySelectorAll('[data-child-search]').forEach((input) => {
                input.addEventListener('input', () => {
                    const target = input.dataset.childSearch;
                    const term = input.value.trim().toLowerCase();

                    document.querySelectorAll(`[data-child-row="${target}"]`).forEach((row) => {
                        row.hidden = !row.dataset.childText.includes(term);
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
