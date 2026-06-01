@extends('layouts.clean')

@section('title', 'Sign In')

@section('clean')

@php
    $role = request('role');
    $portal = $role === 'guardian' ? 'Guardian' : ($role === 'student' ? 'Student' : 'Staff');
@endphp

<main class="relative flex min-h-screen w-full items-center justify-center overflow-hidden bg-slate-950 bg-center bg-cover px-5 py-10 font-sans"
    style="background-image: url('{{ asset('images/ccnhs-gate.webp') }}');">

    <div class="absolute inset-0 bg-black/50"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-sky-950/80 via-slate-950/45 to-emerald-950/70"></div>

    <div class="relative z-10 grid w-full max-w-6xl grid-cols-1 overflow-hidden rounded-[28px] border border-white/15 bg-white/10 shadow-2xl shadow-slate-950/50 backdrop-blur-xl md:grid-cols-[1.08fr_0.92fr]">

        <!-- LEFT: BRAND PANEL -->
        <section class="relative flex min-h-[320px] flex-col justify-between border-b border-white/10 p-8 text-white md:min-h-[560px] md:border-b-0 md:border-r md:p-12">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-100/80">
                    Cauayan City National High School
                </p>

                <h1 class="mt-8 max-w-xl text-4xl font-black leading-[1.02] tracking-tight sm:text-5xl lg:text-6xl">
                    Grading System
                </h1>

                <p class="mt-5 max-w-lg text-base leading-7 text-slate-100/85 sm:text-lg">
                    Manage student grades, records, and academic performance with a focused workspace built for everyday school operations.
                </p>
            </div>

            <div class="mt-10 grid max-w-xl grid-cols-2 gap-3 text-sm text-slate-100/85 sm:grid-cols-3">
                <div class="rounded-xl border border-white/12 bg-white/10 px-4 py-3">
                    <span class="block text-lg font-bold text-white">Fast</span>
                    Grade entry
                </div>
                <div class="rounded-xl border border-white/12 bg-white/10 px-4 py-3">
                    <span class="block text-lg font-bold text-white">Clear</span>
                    Student records
                </div>
                <div class="col-span-2 rounded-xl border border-white/12 bg-white/10 px-4 py-3 sm:col-span-1">
                    <span class="block text-lg font-bold text-white">Secure</span>
                    Staff access
                </div>
            </div>
        </section>

        <!-- RIGHT: LOGIN PANEL -->
        <section class="flex items-center justify-center bg-slate-50 px-5 py-8 sm:px-8 md:px-10">
            <div class="w-full max-w-md">

                <div class="mb-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.18em] text-sky-700">
                        {{ $portal }} Portal
                    </p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">
                        Sign in to continue
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        Use your assigned school account to access grade management.
                    </p>
                </div>

                <form class="space-y-5">

                    <div>
                        <label class="text-sm font-bold text-slate-800">
                            Email or Username
                        </label>
                        <input
                            type="text"
                            placeholder="Enter email or username"
                            class="w-full border-1 border-black/70 rounded-full py-2 px-4 outline-none"
                        >
                    </div>

                    <div>
                        <label class="text-sm font-bold text-slate-800">
                            Password
                        </label>
                        <input
                            type="password"
                            placeholder="Enter password"
                            class="w-full border-1 border-black/70 rounded-full py-2 px-4 outline-none"
                        >
                    </div>

                    <input type="hidden" name="role" value="{{ $role }}">

                    <button
                        type="submit"
                        class="w-full p-2 bg-blue-600 font-bold text-white text-lg
                        hover:bg-blue-700 hover:scale-105 transition suration-300"
                        style="border-radius: 2rem;"
                    >
                        Sign In
                    </button>

                    <p class="text-center text-sm text-slate-600">
                        Don't have an account?
                        <a href="/register" class="font-bold text-sky-700 hover:text-sky-900 hover:underline">
                            Sign Up
                        </a>
                    </p>

                </form>

            </div>
        </section>

    </div>

</main>

@endsection
