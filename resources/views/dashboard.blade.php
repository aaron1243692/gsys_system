@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @if (session('success'))
        <div id="dashboard-message-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-5 backdrop-blur-sm">
            <div class="w-full max-w-sm rounded-xl border border-white/70 bg-white px-6 py-2 text-slate-950 shadow-2xl">
                <div class="relative text-center">
                    <button type="button" onclick="document.getElementById('dashboard-message-modal').remove()" class="absolute right-0 top-0 inline-flex h-9 w-9 items-center justify-center rounded-full text-2xl leading-none text-slate-400 transition hover:bg-slate-100 hover:text-slate-950" aria-label="Close message">
                        &times;
                    </button>

                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 ring-8 ring-emerald-50/60">
                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-600 text-xl font-black text-white">
                            ✓
                        </span>
                    </div>

                    <h3 class="mt-1 text-2xl font-black tracking-tight">Signed in</h3>
                </div>

                <p class="mx-auto mt-1 max-w-sm text-center text-sm leading-6 text-slate-600">
                    {{ session('success') }}
                </p>

                <button type="button" onclick="document.getElementById('dashboard-message-modal').remove()" class="mt-4 w-full rounded-full bg-emerald-600 px-5 py-2.5 text-sm font-black text-white shadow-lg shadow-emerald-600/25 transition hover:bg-emerald-700">
                    Continue
                </button>
            </div>
        </div>
    @endif

    <section class="mx-auto w-full max-w-6xl px-5 py-10">
        <div class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-wider text-sky-700">Dashboard</p>
            <h1 class="mt-2 text-3xl font-black text-slate-950">
                Welcome, {{ auth()->user()->username }}
            </h1>
            <p class="mt-2 text-slate-600">
                You are signed in with the users table account.
            </p>
        </div>
    </section>
@endsection
