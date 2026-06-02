@extends('layouts.app')

@section('title', 'Roles')

@section('content')
    <main class="flex w-full flex-1 flex-col gap-2 px-4 py-2 min-h-0">
        <section class="w-full bg-white p-2">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Setting</p>
            <h1 class="text-3xl font-black text-slate-950">Roles</h1>
        </section>

        @if (session('success') || $errors->any())
            @php
                $isSuccess = session('success') !== null;
                $feedbackTitle = $isSuccess ? 'Success!' : 'Failed!';
                $feedbackMessage = session('success') ?? $errors->first();
                $feedbackColor = $isSuccess ? 'blue' : 'red';
            @endphp

            <div id="role-feedback-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-950/60 px-5 backdrop-blur-sm">
                <div class="w-full max-w-sm rounded-lg border border-slate-200 bg-white p-4 text-center text-slate-950 shadow-2xl">
                    <div class="relative">
                        <h2 class="text-xl font-black {{ $feedbackColor === 'blue' ? 'text-blue-700' : 'text-red-600' }}">{{ $feedbackTitle }}</h2>
                        <button type="button" onclick="document.getElementById('role-feedback-modal').remove()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                            &times;
                        </button>
                    </div>

                    <p class="mx-auto mt-3 max-w-xs text-center text-sm leading-6 text-slate-600">{{ $feedbackMessage }}</p>

                    <button type="button" onclick="document.getElementById('role-feedback-modal').remove()" class="mt-4 w-full rounded-[2rem] {{ $feedbackColor === 'blue' ? 'bg-blue-700 hover:bg-blue-800' : 'bg-red-600 hover:bg-red-700' }} px-4 py-2 text-sm font-bold text-white transition hover:scale-105">
                        OK
                    </button>
                </div>
            </div>
        @endif

        <section class="flex w-full flex-1 min-h-0">
            <div class="flex w-full flex-1 flex-col rounded-lg border border-slate-200 bg-white px-2 py-3 shadow-sm min-h-0">
                <div class="mb-4 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <form method="GET" action="{{ route('configuration.setting.roles') }}" class="flex w-full gap-2 md:max-w-md">

                        @can('asd.view')<input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search role"
                            onchange="this.form.submit()"
                            onsearch="this.form.submit()"
                            class="w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                        >@endcan
                    </form>

                    <button
                        type="button"
                        onclick="document.getElementById('add-role-modal').showModal()"
                        class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800 md:ml-auto"
                        style="border-radius: 2rem;"
                    >
                        Add
                    </button>
                </div>

                <dialog id="add-role-modal" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                    <form method="POST" action="{{ route('configuration.setting.roles.store') }}" class="p-4">
                        @csrf
                        <div class="relative text-center">
                            <h2 class="text-xl font-black">Add</h2>
                            <button type="button" onclick="document.getElementById('add-role-modal').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                &times;
                            </button>
                        </div>

                        <label class="mt-4 block text-sm font-bold text-slate-800" for="new-role-name">Name</label>
                        <input id="new-role-name" type="text" name="name" value="{{ old('name') }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                        <div class="mt-4 flex gap-2">
                            <button type="button" onclick="document.getElementById('add-role-modal').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                <th class="w-72 px-4 py-3 text-right font-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr class="border-b border-slate-200 hover:bg-slate-50">
                                    <td class="px-4 py-2 font-semibold text-slate-500">{{ $roles->firstItem() + $loop->index }}</td>
                                    <td class="px-4 py-2 font-semibold text-slate-700">{{ $role->id }}</td>
                                    <td class="px-4 py-2 font-bold text-slate-950">{{ $role->name }}</td>
                                    <td class="px-4 py-2">
                                        <div class="flex justify-end gap-2">
                                            <button type="button" onclick="document.getElementById('permissions-role-{{ $role->id }}').showModal()" class="rounded-[2rem] border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 transition hover:scale-110 hover:bg-slate-50">
                                                Permissions
                                            </button>
                                            <button type="button" onclick="document.getElementById('edit-role-{{ $role->id }}').showModal()" class="rounded-[2rem] border border-blue-200 px-3 py-1.5 text-xs font-bold text-blue-700 transition hover:scale-110 hover:bg-blue-50">
                                                Edit
                                            </button>
                                            <button type="button" onclick="document.getElementById('delete-role-{{ $role->id }}').showModal()" class="rounded-[2rem] border border-red-200 px-3 py-1.5 text-xs font-bold text-red-600 transition hover:scale-110 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </div>

                                        <dialog id="permissions-role-{{ $role->id }}" class="m-auto w-full max-w-4xl max-h-[calc(100vh-2rem)] rounded-xl border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl overflow-hidden backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.setting.roles.permissions.sync', $role) }}" class="flex max-h-[calc(100vh-4rem)] min-h-0 flex-col gap-3 p-4">
                                                @csrf
                                                <div class="flex w-full items-start justify-between gap-3">
                                                    <div>
                                                        <h2 class="text-lg font-black text-slate-950">Modify Permissions</h2>
                                                        <p class="mt-1 text-sm font-semibold text-slate-500">
                                                            Select the pages this role can access for {{ $role->name }}.
                                                        </p>
                                                    </div>
                                                    <button type="button" onclick="document.getElementById('permissions-role-{{ $role->id }}').close()" class="shrink-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                @php
                                                    $assignedPermissionIds = $role->permissions->pluck('id')->all();
                                                @endphp

                                                <div class="grid min-h-0 gap-3 overflow-y-auto pr-1 md:grid-cols-2">
                                                    @forelse ($permissionGroups as $parentPermission)
                                                        @php
                                                            $childPermissionIds = $parentPermission->children->pluck('id')->all();
                                                            $hasCheckedChild = count(array_intersect($childPermissionIds, $assignedPermissionIds)) > 0;
                                                        @endphp

                                                        <article class="rounded-xl border border-slate-200 bg-white p-3">
                                                            <label class="flex cursor-pointer items-center gap-3 text-base font-bold text-slate-800">
                                                                <input
                                                                    type="checkbox"
                                                                    data-parent-permission="permission-group-{{ $role->id }}-{{ $parentPermission->id }}"
                                                                    @checked($hasCheckedChild)
                                                                    class="h-4 w-4 rounded border-slate-300 text-blue-700 accent-blue-700 focus:ring-blue-500"
                                                                >
                                                                <span>{{ $parentPermission->name }}</span>
                                                            </label>

                                                            <div class="mt-3 flex flex-col gap-2 pl-2">
                                                                @forelse ($parentPermission->children as $permission)
                                                                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-slate-100 bg-slate-50 px-3 py-2 text-sm font-semibold text-slate-700">
                                                                        <input
                                                                            type="checkbox"
                                                                            name="permission_ids[]"
                                                                            value="{{ $permission->id }}"
                                                                            data-child-permission="permission-group-{{ $role->id }}-{{ $parentPermission->id }}"
                                                                            @checked(in_array($permission->id, $assignedPermissionIds, true))
                                                                            class="h-4 w-4 rounded border-slate-300 text-blue-700 accent-blue-700 focus:ring-blue-500"
                                                                        >
                                                                        <span class="min-w-0 truncate">{{ $permission->name }}</span>
                                                                    </label>
                                                                @empty
                                                                    <p class="rounded-lg border border-slate-100 bg-slate-50 px-3 py-4 text-center text-sm font-semibold text-slate-500">
                                                                        No pages found.
                                                                    </p>
                                                                @endforelse
                                                            </div>
                                                        </article>
                                                    @empty
                                                        <p class="rounded-lg border border-slate-200 px-4 py-8 text-center text-sm font-semibold text-slate-500 md:col-span-2">
                                                            No permissions found.
                                                        </p>
                                                    @endforelse
                                                </div>

                                                <div class="flex w-full shrink-0 justify-center gap-2 border-t border-slate-200 pt-3">
                                                    <button type="button" onclick="document.getElementById('permissions-role-{{ $role->id }}').close()" class="rounded-[2rem] bg-slate-900 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-slate-800">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Save Permissions
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="edit-role-{{ $role->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.setting.roles.update', $role) }}" class="p-4">
                                                @csrf
                                                @method('PUT')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Edit</h2>
                                                    <button type="button" onclick="document.getElementById('edit-role-{{ $role->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <label class="mt-4 block text-sm font-bold text-slate-800" for="role-name-{{ $role->id }}">Name</label>
                                                <input id="role-name-{{ $role->id }}" type="text" name="name" value="{{ old('name', $role->name) }}" required class="mt-1.5 w-full rounded-[2rem] border border-slate-300 px-3 py-2 text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('edit-role-{{ $role->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
                                                        Cancel
                                                    </button>
                                                    <button type="submit" class="w-full rounded-[2rem] bg-blue-700 px-4 py-2 text-sm font-bold text-white transition hover:scale-105 hover:bg-blue-800">
                                                        Save
                                                    </button>
                                                </div>
                                            </form>
                                        </dialog>

                                        <dialog id="delete-role-{{ $role->id }}" class="m-auto w-full max-w-sm rounded-lg border border-slate-200 bg-white p-0 text-slate-950 shadow-2xl backdrop:bg-slate-950/50">
                                            <form method="POST" action="{{ route('configuration.setting.roles.destroy', $role) }}" class="p-4">
                                                @csrf
                                                @method('DELETE')
                                                <div class="relative text-center">
                                                    <h2 class="text-xl font-black">Delete!</h2>
                                                    <button type="button" onclick="document.getElementById('delete-role-{{ $role->id }}').close()" class="absolute right-0 top-0 border-0 outline-none ring-0 rounded-full px-3 py-1 text-2xl leading-none text-slate-400 hover:bg-slate-100 hover:text-slate-950 focus:outline-none focus:ring-0">
                                                        &times;
                                                    </button>
                                                </div>

                                                <p class="mt-3 text-center text-sm leading-6 text-slate-600">
                                                    Are you sure you want to delete <span class="font-bold text-slate-950">{{ $role->name }}</span>?
                                                </p>

                                                <div class="mt-4 flex gap-2">
                                                    <button type="button" onclick="document.getElementById('delete-role-{{ $role->id }}').close()" class="w-full rounded-[2rem] border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:scale-105 hover:bg-slate-50">
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
                                    <td colspan="4" class="px-4 py-10 text-center text-sm font-semibold text-slate-500">
                                        No roles found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($roles->hasPages())
                    <div class="mt-4 flex flex-col gap-3 border-t border-slate-100 pt-3 md:flex-row md:items-center md:justify-between">
                        <p class="text-sm font-semibold text-slate-500">
                            Showing {{ $roles->firstItem() }} to {{ $roles->lastItem() }} of {{ $roles->total() }}
                        </p>

                        <nav class="flex items-center gap-1" aria-label="Pagination">
                            @if ($roles->onFirstPage())
                                <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-300">&lt;</span>
                            @else
                                <a href="{{ $roles->previousPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&lt;</a>
                            @endif

                            @foreach ($roles->getUrlRange(1, $roles->lastPage()) as $page => $url)
                                @if ($page === $roles->currentPage())
                                    <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-full bg-blue-700 px-3 text-sm font-black text-white shadow-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-blue-50 hover:text-blue-700">{{ $page }}</a>
                                @endif
                            @endforeach

                            @if ($roles->hasMorePages())
                                <a href="{{ $roles->nextPageUrl() }}" class="inline-flex h-9 min-w-9 items-center justify-center rounded-full border border-slate-200 px-3 text-sm font-bold text-slate-600 text-decoration-none transition hover:scale-105 hover:bg-slate-50">&gt;</a>
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
            const openModalId = @json(session('open_modal'));

            document.querySelectorAll('dialog').forEach((dialog) => {
                dialog.addEventListener('click', (event) => {
                    if (event.target === dialog) {
                        dialog.close();
                    }
                });
            });

            if (openModalId) {
                const modal = document.getElementById(openModalId);

                if (modal && typeof modal.showModal === 'function') {
                    modal.showModal();
                }
            }

            document.querySelectorAll('[data-parent-permission]').forEach((parent) => {
                const group = parent.dataset.parentPermission;
                const children = Array.from(document.querySelectorAll(`[data-child-permission="${group}"]`));

                parent.addEventListener('change', () => {
                    children.forEach((child) => {
                        child.checked = parent.checked;
                    });
                });

                children.forEach((child) => {
                    child.addEventListener('change', () => {
                        parent.checked = children.some((item) => item.checked);
                    });
                });
            });
        });
    </script>
@endsection
