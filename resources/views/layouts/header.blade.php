@php
    $sidebarLinkClass = fn (bool $active) => ($active
        ? 'bg-blue-700 text-white shadow-sm'
        : 'text-slate-600 hover:bg-slate-100 hover:text-slate-950')
        . ' flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold text-decoration-none transition-colors';

    $sidebarIconClass = fn (bool $active) => 'h-5 w-5 shrink-0' . ($active ? ' brightness-0 invert' : '');

    $isConfigurationGroup = request()->routeIs('configuration.curriculum.*');
    $isAcademicGroup = request()->routeIs('academic.*');
    $isReportsGroup = request()->routeIs('report.*');
    $isAccountsGroup = request()->routeIs('configuration.accounts.*');
    $isSettingGroup = request()->routeIs('configuration.setting.*');

    $groupButtonClass = fn (bool $active) => ($active
        ? 'bg-blue-50 text-blue-700'
        : 'text-slate-500 hover:bg-slate-100 hover:text-slate-900')
        . ' mt-4 flex w-full items-center justify-between rounded-lg px-3 py-2 text-left text-xs font-bold uppercase tracking-widest transition-colors';
@endphp

<div
    data-sidebar-overlay
    class="fixed inset-0 z-40 hidden bg-slate-950/40 lg:hidden"
    aria-hidden="true"
></div>

<aside
    data-sidebar
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white px-4 py-5 shadow-xl transition-transform duration-200 lg:translate-x-0 lg:shadow-none"
>
    <a href="/dashboard" class="flex items-center gap-3 text-decoration-none">
        <span class="inline-flex h-11 w-11 items-center justify-center rounded-lg bg-slate-900 text-sm font-bold text-white shadow-sm">
            G
        </span>
        <span>
            <span class="block text-lg font-black leading-tight text-slate-950">GSYS</span>
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-400">School System</span>
        </span>
    </a>

    <nav class="mt-8 flex flex-1 flex-col gap-1 overflow-y-auto pb-4" aria-label="Main navigation">
        <p class="mb-2 px-3 text-xs font-bold uppercase tracking-widest text-slate-400">Pages</p>

        <a href="{{ route('dashboard') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('dashboard')) }}" aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
            <img src="{{ asset('icons/list.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('dashboard')) }}">
            <span>Dashboard</span>
        </a>

        <button type="button" data-sidebar-group-toggle class="{{ $groupButtonClass($isConfigurationGroup) }}" aria-expanded="{{ $isConfigurationGroup ? 'true' : 'false' }}" aria-controls="sidebar-configuration-menu">
            <span>Configuration</span>
            <span data-sidebar-group-arrow class="text-sm transition-transform duration-300">&#9662;</span>
        </button>
        <div id="sidebar-configuration-menu" data-sidebar-group-menu class="flex flex-col gap-1 overflow-hidden transition-all duration-300 ease-in-out">
            <a href="{{ route('configuration.curriculum.grade-level') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('configuration.curriculum.grade-level')) }}" aria-current="{{ request()->routeIs('configuration.curriculum.grade-level') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/crown.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('configuration.curriculum.grade-level')) }}">
                <span>Grade Level</span>
            </a>
            <a href="{{ route('configuration.curriculum.academic-year') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('configuration.curriculum.academic-year')) }}" aria-current="{{ request()->routeIs('configuration.curriculum.academic-year') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/crown.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('configuration.curriculum.academic-year')) }}">
                <span>Academic Year</span>
            </a>
            <a href="{{ route('configuration.curriculum.class') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('configuration.curriculum.class')) }}" aria-current="{{ request()->routeIs('configuration.curriculum.class') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/crown.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('configuration.curriculum.class')) }}">
                <span>Class</span>
            </a>
            <a href="{{ route('configuration.curriculum.subject-category') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('configuration.curriculum.subject-category')) }}" aria-current="{{ request()->routeIs('configuration.curriculum.subject-category') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/crown.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('configuration.curriculum.subject-category')) }}">
                <span>Subject Category</span>
            </a>
            <a href="{{ route('configuration.curriculum.subjects') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('configuration.curriculum.subjects')) }}" aria-current="{{ request()->routeIs('configuration.curriculum.subjects') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/crown.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('configuration.curriculum.subjects')) }}">
                <span>Subjects</span>
            </a>
            <a href="{{ route('configuration.curriculum.tracks') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('configuration.curriculum.tracks')) }}" aria-current="{{ request()->routeIs('configuration.curriculum.tracks') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/crown.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('configuration.curriculum.tracks')) }}">
                <span>Track</span>
            </a>
        </div>

        <button type="button" data-sidebar-group-toggle class="{{ $groupButtonClass($isAcademicGroup) }}" aria-expanded="{{ $isAcademicGroup ? 'true' : 'false' }}" aria-controls="sidebar-academic-menu">
            <span>Academic</span>
            <span data-sidebar-group-arrow class="text-sm transition-transform duration-300">&#9662;</span>
        </button>
        <div id="sidebar-academic-menu" data-sidebar-group-menu class="flex flex-col gap-1 overflow-hidden transition-all duration-300 ease-in-out">
            <a href="{{ route('academic.schedule-load.class-schedule') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('academic.schedule-load.class-schedule')) }}" aria-current="{{ request()->routeIs('academic.schedule-load.class-schedule') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/schedule.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('academic.schedule-load.class-schedule')) }}">
                <span>Class Schedule</span>
            </a>
            <a href="{{ route('academic.schedule-load.teacher-load') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('academic.schedule-load.teacher-load')) }}" aria-current="{{ request()->routeIs('academic.schedule-load.teacher-load') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/emsched.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('academic.schedule-load.teacher-load')) }}">
                <span>Teacher Load</span>
            </a>
            <a href="{{ route('academic.schedule-load.rooms') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('academic.schedule-load.rooms')) }}" aria-current="{{ request()->routeIs('academic.schedule-load.rooms') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/higher-education.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('academic.schedule-load.rooms')) }}">
                <span>Rooms</span>
            </a>
            <a href="{{ route('academic.students.index') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('academic.students.index')) }}" aria-current="{{ request()->routeIs('academic.students.index') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/backpack.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('academic.students.index')) }}">
                <span>Students</span>
            </a>
            <a href="{{ route('academic.students.pre-enlistment') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('academic.students.pre-enlistment')) }}" aria-current="{{ request()->routeIs('academic.students.pre-enlistment') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/academic-success.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('academic.students.pre-enlistment')) }}">
                <span>Pre-Admission</span>
            </a>
        </div>

        <button type="button" data-sidebar-group-toggle class="{{ $groupButtonClass($isReportsGroup) }}" aria-expanded="{{ $isReportsGroup ? 'true' : 'false' }}" aria-controls="sidebar-reports-menu">
            <span>Reports</span>
            <span data-sidebar-group-arrow class="text-sm transition-transform duration-300">&#9662;</span>
        </button>
        <div id="sidebar-reports-menu" data-sidebar-group-menu class="flex flex-col gap-1 overflow-hidden transition-all duration-300 ease-in-out">
            <a href="{{ route('report.performance.top-student') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('report.performance.top-student')) }}" aria-current="{{ request()->routeIs('report.performance.top-student') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/print.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('report.performance.top-student')) }}">
                <span>Top Student</span>
            </a>
            <a href="{{ route('report.performance.top-class') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('report.performance.top-class')) }}" aria-current="{{ request()->routeIs('report.performance.top-class') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/print.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('report.performance.top-class')) }}">
                <span>Top Class</span>
            </a>
            <a href="{{ route('report.grades') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('report.grades')) }}" aria-current="{{ request()->routeIs('report.grades') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/book.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('report.grades')) }}">
                <span>Grades</span>
            </a>
            <a href="{{ route('report.grades.approval') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('report.grades.approval')) }}" aria-current="{{ request()->routeIs('report.grades.approval') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/pencil.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('report.grades.approval')) }}">
                <span>Approval</span>
            </a>
        </div>

        <button type="button" data-sidebar-group-toggle class="{{ $groupButtonClass($isAccountsGroup) }}" aria-expanded="{{ $isAccountsGroup ? 'true' : 'false' }}" aria-controls="sidebar-accounts-menu">
            <span>Accounts</span>
            <span data-sidebar-group-arrow class="text-sm transition-transform duration-300">&#9662;</span>
        </button>
        <div id="sidebar-accounts-menu" data-sidebar-group-menu class="flex flex-col gap-1 overflow-hidden transition-all duration-300 ease-in-out">
            <a href="{{ route('configuration.accounts.students') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('configuration.accounts.students')) }}" aria-current="{{ request()->routeIs('configuration.accounts.students') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/children.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('configuration.accounts.students')) }}">
                <span>Students</span>
            </a>
            <a href="{{ route('configuration.accounts.guardians') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('configuration.accounts.guardians')) }}" aria-current="{{ request()->routeIs('configuration.accounts.guardians') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/adult.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('configuration.accounts.guardians')) }}">
                <span>Guardians</span>
            </a>
            <a href="{{ route('configuration.accounts.teachers') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('configuration.accounts.teachers')) }}" aria-current="{{ request()->routeIs('configuration.accounts.teachers') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/employee.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('configuration.accounts.teachers')) }}">
                <span>Teachers</span>
            </a>
        </div>

        <button type="button" data-sidebar-group-toggle class="{{ $groupButtonClass($isSettingGroup) }}" aria-expanded="{{ $isSettingGroup ? 'true' : 'false' }}" aria-controls="sidebar-setting-menu">
            <span>Setting</span>
            <span data-sidebar-group-arrow class="text-sm transition-transform duration-300">&#9662;</span>
        </button>
        <div id="sidebar-setting-menu" data-sidebar-group-menu class="flex flex-col gap-1 overflow-hidden transition-all duration-300 ease-in-out">
            <a href="{{ route('configuration.setting.users') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('configuration.setting.users')) }}" aria-current="{{ request()->routeIs('configuration.setting.users') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/user.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('configuration.setting.users')) }}">
                <span>Users</span>
            </a>
            <a href="{{ route('configuration.setting.roles') }}" data-sidebar-link class="{{ $sidebarLinkClass(request()->routeIs('configuration.setting.roles')) }}" aria-current="{{ request()->routeIs('configuration.setting.roles') ? 'page' : 'false' }}">
                <img src="{{ asset('icons/key.png') }}" alt="" class="{{ $sidebarIconClass(request()->routeIs('configuration.setting.roles')) }}">
                <span>Roles</span>
            </a>
        </div>
    </nav>
</aside>

<header class="sticky top-0 z-30 w-full border-bottom bg-white shadow-sm lg:ml-72 lg:w-[calc(100%-18rem)]">
    <nav class="flex w-full items-center justify-between gap-3 px-4 py-3">
        <div class="flex items-center gap-3">
            <button
                type="button"
                data-sidebar-open
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-xl font-bold text-slate-700 transition hover:bg-slate-100 lg:hidden"
                aria-label="Open navigation menu"
            >
                &#9776;
            </button>

            <a href="/dashboard" class="flex items-center gap-3 text-decoration-none">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-slate-900 text-sm font-bold text-white shadow-sm">
                    G
                </span>
                <span class="text-lg font-semibold text-slate-900">GSYS</span>
            </a>
        </div>

        @auth
            <details class="group relative shrink-0">
                <summary class="flex cursor-pointer list-none items-center gap-2 rounded-full border border-slate-200 bg-white py-1.5 pl-2 pr-3 text-sm font-semibold text-slate-800 shadow-sm transition hover:bg-slate-50">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-700 text-xs font-bold uppercase text-white">
                        {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                    </span>
                    <span class="max-w-32 truncate">{{ auth()->user()->username }}</span>
                    <span class="text-slate-400 transition group-open:rotate-180">&#9662;</span>
                </summary>

                <div class="absolute right-0 z-40 mt-2 w-52 rounded-lg border border-slate-200 bg-white p-2 text-slate-900 shadow-xl">
                    <div class="border-b border-slate-100 px-3 py-2">
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Signed in as</p>
                        <p class="mt-1 truncate text-sm font-bold">{{ auth()->user()->username }}</p>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full rounded-md px-3 py-2 text-left text-sm font-semibold text-red-600 transition hover:bg-red-50">
                            Sign Out
                        </button>
                    </form>
                </div>
            </details>
        @endauth
    </nav>
</header>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.querySelector('[data-sidebar]');
        const sidebarOverlay = document.querySelector('[data-sidebar-overlay]');
        const sidebarOpenButton = document.querySelector('[data-sidebar-open]');
        const sidebarLinks = document.querySelectorAll('[data-sidebar-link]');
        const groupButtons = document.querySelectorAll('[data-sidebar-group-toggle]');

        const openSidebar = () => {
            sidebar?.classList.remove('-translate-x-full');
            sidebarOverlay?.classList.remove('hidden');
        };

        const closeSidebar = () => {
            sidebar?.classList.add('-translate-x-full');
            sidebarOverlay?.classList.add('hidden');
        };

        const setGroupOpen = (button, isOpen) => {
            const menu = document.getElementById(button.getAttribute('aria-controls'));
            const arrow = button.querySelector('[data-sidebar-group-arrow]');

            if (!menu) {
                return;
            }

            button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            menu.style.maxHeight = isOpen ? `${menu.scrollHeight}px` : '0px';
            arrow?.classList.toggle('-rotate-90', !isOpen);
        };

        groupButtons.forEach((button) => {
            setGroupOpen(button, button.getAttribute('aria-expanded') === 'true');

            button.addEventListener('click', () => {
                setGroupOpen(button, button.getAttribute('aria-expanded') !== 'true');
            });
        });

        window.addEventListener('resize', () => {
            groupButtons.forEach((button) => {
                if (button.getAttribute('aria-expanded') === 'true') {
                    setGroupOpen(button, true);
                }
            });
        });

        sidebarOpenButton?.addEventListener('click', openSidebar);
        sidebarOverlay?.addEventListener('click', closeSidebar);
        sidebarLinks.forEach((link) => link.addEventListener('click', closeSidebar));
    });
</script>
