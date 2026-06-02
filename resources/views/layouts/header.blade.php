<header class="w-full border-bottom bg-white shadow-sm">
    <nav class="flex w-full flex-col gap-3 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
        <a href="/dashboard" class="flex items-center gap-3 text-decoration-none">
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-md bg-slate-900 text-sm font-bold text-white shadow-sm">
                G
            </span>
            <span class="text-lg font-semibold text-slate-900">GSYS</span>
        </a>

        <nav class="flex w-full gap-1 overflow-x-auto rounded-md border border-slate-200 bg-slate-50 p-1 sm:w-auto">
            <button type="button" class="whitespace-nowrap rounded-md bg-white px-4 py-2 text-sm font-semibold text-blue-700 shadow-sm ring-1 ring-slate-200">
                Dashboard
            </button>
            <button
                type="button"
                data-configuration-open
                class="whitespace-nowrap rounded-md px-4 py-2 text-sm font-medium text-slate-600 transition-colors hover:bg-white hover:text-slate-950"
            >
                Setup
            </button>
            <button
                type="button"
                data-academic-open
                class="whitespace-nowrap rounded-md px-4 py-2 text-sm font-medium text-slate-600 transition-colors hover:bg-white hover:text-slate-950"
            >
                Academic
            </button>
            <button
                type="button"
                data-report-open
                class="whitespace-nowrap rounded-md px-4 py-2 text-sm font-medium text-slate-600 transition-colors hover:bg-white hover:text-slate-950"
            >
                Report
            </button>
        </nav>

        @auth
            <details class="group relative shrink-0">
                <summary class="flex cursor-pointer list-none items-center gap-2 rounded-full border border-slate-200 bg-white py-1.5 pl-2 pr-3 text-sm font-semibold text-slate-800 shadow-sm transition hover:bg-slate-50">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-700 text-xs font-bold uppercase text-white">
                        {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                    </span>
                    <span class="max-w-32 truncate">{{ auth()->user()->username }}</span>
                    <span class="text-slate-400 transition group-open:rotate-180">▾</span>
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

<dialog
    id="configuration-pages-panel"
    aria-labelledby="configuration-pages-title"
    class="m-auto rounded-2xl border border-slate-200 bg-white p-0 text-slate-900 shadow-2xl backdrop:bg-slate-950/50"
>
    <section class="flex flex-col overflow-hidden rounded-2xl">
        <div class="flex items-start justify-between gap-6 border-b border-slate-200 px-6 py-5">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-blue-700">Setup</p>
                <h4 id="configuration-pages-title" class="mt-1 text-2xl font-bold tracking-tight text-slate-950">
                    Setup Panel
                </h4>
                <p class="mt-1 text-sm leading-6 text-slate-500">
                    Choose a setup area to manage curriculum, accounts, and access settings.
                </p>
            </div>

            <button
                type="button"
                data-configuration-close
                aria-label="Close configuration panel"
                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 text-xl leading-none text-slate-500 transition hover:bg-slate-100 hover:text-slate-950"
            >
                &times;
            </button>
        </div>

        <div class="flex flex-row flex-nowrap items-start gap-1 overflow-x-auto bg-slate-50 px-6 py-6">

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <h6 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-500">Configuration</h6>
                <div class="grid grid-rows-2 grid-flow-col gap-2">
                    <a href="{{ route('configuration.curriculum.grade-level') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700"
                    >
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Grade Level</span>
                    </a>
                    <a href="{{ route('configuration.curriculum.academic-year') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700"
                    >
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Academic Year</span>
                    </a>
                    <a href="{{ route('configuration.curriculum.class') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700"
                    >
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Class</span>
                    </a>
                    <a href="{{ route('configuration.curriculum.subject-category') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700"
                    >
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Subject Category</span>
                    </a>
                    <a href="{{ route('configuration.curriculum.subjects') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700"
                    >
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Subjects</span>
                    </a>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <h6 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-500">Accounts</h6>
                <div class="grid grid-rows-2 grid-flow-col gap-2">
                    <a href="{{ route('configuration.accounts.students') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700"
                    >
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Students</span>
                    </a>
                    <a href="{{ route('configuration.accounts.guardians') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700"
                    >
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Guardians</span>
                    </a>
                    <a href="{{ route('configuration.accounts.teachers') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700">
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Teachers</span>
                    </a>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <h6 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-500">Setting</h6>
                <div class="grid grid-rows-2 grid-flow-col gap-2">
                    <a href="{{ route('configuration.setting.users') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700"
                    >
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Users</span>
                    </a>
                    <a href="{{ route('configuration.setting.roles') }}" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700"
                    >
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Roles</span>
                    </a>
                </div>
            </div>

        </div>
    </section>
</dialog>

<dialog
    id="academic-pages-panel"
    aria-labelledby="academic-pages-title"
    class="m-auto rounded-2xl border border-slate-200 bg-white p-0 text-slate-900 shadow-2xl backdrop:bg-slate-950/50"
>
    <section class="flex flex-col overflow-hidden rounded-2xl">
        <div class="flex items-start justify-between gap-6 border-b border-slate-200 px-6 py-5">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-blue-700">Academic</p>
                <h4 id="academic-pages-title" class="mt-1 text-2xl font-bold tracking-tight text-slate-950">
                    Academic Panel
                </h4>
                <p class="mt-1 text-sm leading-6 text-slate-500">
                    Manage teaching assignments, faculty records, students, and teachers.
                </p>
            </div>

            <button
                type="button"
                data-academic-close
                aria-label="Close academic panel"
                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 text-xl leading-none text-slate-500 transition hover:bg-slate-100 hover:text-slate-950"
            >
                &times;
            </button>
        </div>

        <div class="flex flex-row flex-nowrap items-start gap-1 overflow-x-auto bg-slate-50 px-6 py-6">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <h6 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-500">Teacher Assignment</h6>
                <div class="grid grid-rows-2 grid-flow-col gap-2">
                    <a href="#" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700">
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Assign Subjects</span>
                    </a>
                    <a href="#" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700">
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Assign Class</span>
                    </a>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <h6 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-500">Students</h6>
                <div class="grid grid-rows-2 grid-flow-col gap-2">
                    <a href="#" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700">
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Students</span>
                    </a>
                    <a href="#" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700">
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Pre-enlistment</span>
                    </a>
                </div>
            </div>

        </div>
    </section>
</dialog>

<dialog
    id="report-pages-panel"
    aria-labelledby="report-pages-title"
    class="m-auto rounded-2xl border border-slate-200 bg-white p-0 text-slate-900 shadow-2xl backdrop:bg-slate-950/50"
>
    <section class="flex flex-col overflow-hidden rounded-2xl">
        <div class="flex items-start justify-between gap-6 border-b border-slate-200 px-6 py-5">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-blue-700">Reports</p>
                <h4 id="report-pages-title" class="mt-1 text-2xl font-bold tracking-tight text-slate-950">
                    Reports Panel
                </h4>
                <p class="mt-1 text-sm leading-6 text-slate-500">
                    Review performance summaries and grade reports.
                </p>
            </div>

            <button
                type="button"
                data-report-close
                aria-label="Close reports panel"
                class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-slate-200 text-xl leading-none text-slate-500 transition hover:bg-slate-100 hover:text-slate-950"
            >
                &times;
            </button>
        </div>

        <div class="flex flex-row flex-nowrap items-start gap-1 overflow-x-auto bg-slate-50 px-6 py-6">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <h6 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-500">Performance</h6>
                <div class="grid grid-rows-2 grid-flow-col gap-2">
                    <a href="#" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700">
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Top Student</span>
                    </a>
                    <a href="#" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700">
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Top Class</span>
                    </a>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <h6 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-500">Grades</h6>
                <div class="grid grid-rows-2 grid-flow-col gap-2">
                    <a href="#" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700">
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Grades</span>
                    </a>
                    <a href="#" class="inline-flex items-center gap-2 whitespace-nowrap rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm font-semibold text-slate-800 text-decoration-none transition hover:border-blue-200 hover:bg-white hover:text-blue-700">
                        <img src="{{ asset('icons/crown.png') }}" alt="" class="h-4 w-4 shrink-0">
                        <span>Final</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
</dialog>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const setupPanel = (panelId, openSelector, closeSelector) => {
            const panel = document.getElementById(panelId);
            const openButton = document.querySelector(openSelector);
            const closeButtons = document.querySelectorAll(closeSelector);

            if (!panel || !openButton) {
                return;
            }

            openButton.addEventListener('click', () => {
                if (typeof panel.showModal === 'function') {
                    panel.showModal();
                    return;
                }

                panel.setAttribute('open', '');
            });

            closeButtons.forEach((button) => {
                button.addEventListener('click', () => panel.close());
            });

            panel.addEventListener('click', (event) => {
                if (event.target === panel) {
                    panel.close();
                }
            });
        };

        setupPanel('configuration-pages-panel', '[data-configuration-open]', '[data-configuration-close]');
        setupPanel('academic-pages-panel', '[data-academic-open]', '[data-academic-close]');
        setupPanel('report-pages-panel', '[data-report-open]', '[data-report-close]');
    });
</script>
