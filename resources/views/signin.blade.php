@extends('layouts.clean')
@php
    $loginPortal = $loginPortal ?? 'Staff';
    $loginAction = $loginAction ?? route('signin.store');
    $loginField = $loginField ?? 'login';
    $loginFieldLabel = $loginFieldLabel ?? 'Email or Username';
    $loginFieldPlaceholder = $loginFieldPlaceholder ?? 'Enter email or username';
    $loginRemember = $loginRemember ?? true;
    $showPortalLinks = $showPortalLinks ?? true;
    $registrationUrl = $registrationUrl ?? null;
@endphp
@section('title', $loginPortal.' Sign In')
@section('clean')
<style>
    .gs-login, .gs-login * { box-sizing: border-box; }
    .gs-login {
        width: 100%; min-height: 100vh; min-height: 100dvh;
        display: grid; place-items: center; padding: 32px 20px;
        background-color: #172554;
        background-size: cover; background-position: center; background-repeat: no-repeat;
        color: #0f172a; font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        font-size: 14px; line-height: 1.5;
    }
    .gs-login .gs-login-card {
        width: 100%; max-width: 1020px; min-width: 0; min-height: 500px; padding: 0;
        display: grid; grid-template-columns: 54% 46%; overflow: hidden;
        border: 1px solid #cbd5e1; border-radius: 24px; background: transparent;
        box-shadow: 0 24px 64px #02061740;
    }
    .gs-login p, .gs-login h1, .gs-login h2 { margin: 0; }
    .gs-login .gs-login-brand { min-width: 0; padding: 42px; display: flex; flex-direction: column; justify-content: space-between; gap: 48px; color: #fff; background: linear-gradient(145deg, rgba(48, 74, 94, .96), rgba(42, 55, 74, .97) 45%, rgba(76, 94, 101, .95)); }
    .gs-login .gs-login-panel { min-width: 0; padding: 64px 42px 32px; background: #f8fafc; }
    .gs-login .gs-login-features { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 14px; }
    .gs-login .gs-login-feature { padding: 14px 18px; border: 1px solid #cbd5e1; border-radius: 11px; background: #ffffff0d; }
    .gs-login .gs-login-feature strong { display: block; font-size: 16px; font-weight: 750; }
    .gs-login .gs-login-feature span { display: block; margin-top: 3px; font-size: 12px; color: #e2e8f0; }
    .gs-login .gs-login-portal-label { color: #0369a1; font-size: 13px; letter-spacing: 1.5px; font-weight: 600; margin-bottom: 14px; }

    .gs-login .gs-login-school { color: #cbd5e1; font-size: 12px; letter-spacing: 2px; text-transform: uppercase; font-weight: 750; }
    .gs-login h1 { margin: 26px 0 40px; color: #fff; font-size: 52px; line-height: 1.08; letter-spacing: -2px; font-weight: 800; }
    .gs-login .gs-login-description { color: #475569; font-size: 13px; line-height: 1.65; }
    .gs-login .gs-login-heading { margin: 0 0 28px; }
    .gs-login .gs-login-brand .gs-login-description { color: #e2e8f0; font-size: 16px; line-height: 1.6; }
    .gs-login h2 { font-size: 28px; line-height: 1.2; letter-spacing: -.8px; font-weight: 750; margin-bottom: 10px; }
    .gs-login .gs-login-form { display: flex; flex-direction: column; gap: 18px; margin: 0; }
    .gs-login .gs-login-label { display: block; margin-bottom: 7px; color: #334155; font-size: 13px; font-weight: 700; }
    .gs-login .gs-login-input {
        display: block; width: 100%; min-height: 48px; padding: 11px 14px; margin: 0;
        border: 1px solid #94a3b8; border-radius: 999px; background: #fff;
        color: #0f172a; font: inherit; font-size: 15px; line-height: 1.4;
    }
    .gs-login .gs-login-input::placeholder { color: #64748b; opacity: 1; }
    .gs-login .gs-login-input:focus { border-color: #1d4ed8; outline: 3px solid #dbeafe; outline-offset: 1px; }
    .gs-login .gs-login-input[aria-invalid=true] { border-color: #b91c1c; }
    .gs-login .gs-login-password { position: relative; }
    .gs-login .gs-login-password input { padding-right: 54px; }
    .gs-login .gs-login-toggle {
        position: absolute; right: 5px; top: 4px; width: 40px; height: 40px;
        display: inline-flex; align-items: center; justify-content: center;
        border: 0; border-radius: 50%; background: transparent; color: #475569; cursor: pointer;
    }
    .gs-login .gs-login-toggle:hover { background: #eff6ff; color: #1d4ed8; }
    .gs-login .gs-login-toggle svg { width: 21px; height: 21px; }
    .gs-login .gs-login-remember { display: flex; align-items: center; gap: 9px; margin: 0; color: #475569; font-size: 12px; cursor: pointer; }
    .gs-login .gs-login-remember input { width: 17px; height: 17px; margin: 0; accent-color: #1d4ed8; flex-shrink: 0; }
    .gs-login .gs-login-submit {
        width: 100%; min-height: 46px; padding: 12px 20px; border: 1px solid #1d4ed8;
        border-radius: 999px; background: #1d4ed8; color: #fff; font: inherit; font-weight: 750; cursor: pointer;
        transition: background-color .15s;
    }
    .gs-login .gs-login-submit:hover { background: #1e40af; }
    .gs-login button:focus-visible, .gs-login a:focus-visible, .gs-login input[type=checkbox]:focus-visible { outline: 3px solid #2563eb; outline-offset: 3px; }
    .gs-login .gs-login-error { margin-top: 7px; color: #b91c1c; font-size: 13px; }
    .gs-login .gs-login-alert { margin-bottom: 18px; padding: 12px 14px; border: 1px solid #fecaca; border-radius: 12px; background: #fef2f2; color: #991b1b; font-size: 13px; }
    .gs-login .gs-login-alert ul { margin: 6px 0 0; padding-left: 18px; }
    .gs-login .gs-login-portals { margin-top: 12px; text-align: center; }
    .gs-login .gs-login-links { display: flex; flex-wrap: wrap; justify-content: center; column-gap: 18px; margin-top: 5px; }
    .gs-login .gs-login-links a { display: inline-flex; align-items: center; min-height: 30px; color: #1d4ed8; font-size: 12px; font-weight: 600; text-decoration: underline; text-underline-offset: 3px; }
    .gs-login .gs-login-links a:hover { color: #172554; }
    .gs-login .gs-login-register { margin-top: 18px; text-align: center; color: #475569; font-size: 13px; }
    .gs-login .gs-login-register a { margin-left: 5px; color: #1d4ed8; font-weight: 700; text-decoration: underline; text-underline-offset: 3px; }
    .gs-login [hidden] { display: none !important; }
    @media (max-width: 1000px) {
        .gs-login .gs-login-brand { padding: 34px 28px; }
        .gs-login .gs-login-panel { padding: 48px 28px 28px; }
        .gs-login h1 { font-size: 44px; }
        .gs-login .gs-login-feature { padding: 13px 10px; }
    }
    @media (max-width: 760px) {
        .gs-login { padding: 24px 14px; }
        .gs-login .gs-login-card { max-width: 560px; grid-template-columns: minmax(0, 1fr); }
        .gs-login .gs-login-brand { padding: 30px; gap: 28px; }
        .gs-login h1 { margin: 20px 0; font-size: 40px; }
        .gs-login .gs-login-panel { padding: 32px 30px; }
    }
    @media (max-width: 400px) {
        .gs-login .gs-login-brand, .gs-login .gs-login-panel { padding: 26px 20px; }
        .gs-login h1 { font-size: 36px; }
        .gs-login h2 { font-size: 26px; }
        .gs-login .gs-login-school { font-size: 11px; letter-spacing: 1.4px; }
        .gs-login .gs-login-features { gap: 8px; }
        .gs-login .gs-login-feature { padding: 12px 8px; }
        .gs-login .gs-login-input { font-size: 16px; }
    }
    @media (prefers-reduced-motion: reduce) { .gs-login .gs-login-submit { transition: none; } }
</style>
<main class="gs-login" style="background-image: linear-gradient(135deg, rgba(6, 26, 49, .68), rgba(2, 12, 28, .60)), url('{{ asset('images/ccnhs-gate.webp') }}');">
    <section class="gs-login-card" aria-labelledby="signin-title">
        <header class="gs-login-brand">
            <div>
            <p class="gs-login-school">Cauayan City National High School</p>
            <h1>Grading System</h1>
            <p class="gs-login-description">Manage student grades, records, and academic performance with a focused workspace built for everyday school operations.</p>
            </div>
            <div class="gs-login-features"><div class="gs-login-feature"><strong>Fast</strong><span>Grade entry</span></div><div class="gs-login-feature"><strong>Clear</strong><span>Student records</span></div><div class="gs-login-feature"><strong>Secure</strong><span>Account access</span></div></div>
        </header>
        <div class="gs-login-panel">
        <div class="gs-login-heading">
            <p class="gs-login-portal-label">{{ mb_strtoupper($loginPortal) }} PORTAL</p>
            <h2 id="signin-title">Sign in to continue</h2>
            <p class="gs-login-description">Use your assigned school account to access the grading system.</p>
        </div>
        @if(session('error') || $errors->any())
            <div class="gs-login-alert" role="alert">
                <strong>Unable to sign in</strong>
                @if(session('error'))<p>{{ session('error') }}</p>@endif
                @if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
            </div>
        @endif
        <form method="POST" action="{{ $loginAction }}" class="gs-login-form">
            @csrf
            <div>
                <label class="gs-login-label" for="signin-login">{{ $loginFieldLabel }}</label>
                <input id="signin-login" class="gs-login-input" type="text" name="{{ $loginField }}" value="{{ old($loginField) }}" placeholder="{{ $loginFieldPlaceholder }}" autocomplete="username" required @error($loginField) aria-invalid="true" aria-describedby="signin-login-error" @enderror>
                @error($loginField)<p id="signin-login-error" class="gs-login-error">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="gs-login-label" for="signin-password">Password</label>
                <div class="gs-login-password">
                    <input id="signin-password" class="gs-login-input" type="password" name="password" placeholder="Enter password" autocomplete="current-password" required @error('password') aria-invalid="true" aria-describedby="signin-password-error" @enderror>
                    <button id="signin-password-toggle" class="gs-login-toggle" type="button" aria-label="Show password" aria-controls="signin-password" aria-pressed="false" hidden>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/><path data-password-slash d="m3 3 18 18" hidden/></svg>
                    </button>
                </div>
                @error('password')<p id="signin-password-error" class="gs-login-error">{{ $message }}</p>@enderror
            </div>
            @if($loginRemember)<label class="gs-login-remember" for="signin-remember"><input id="signin-remember" type="checkbox" name="remember" value="1" @checked(old('remember'))>Remember me</label>@endif
            @if($loginPortal === 'Staff')<input type="hidden" name="role" value="{{ request('role') }}">@endif
            <button type="submit" class="gs-login-submit">Sign In</button>
        </form>
        @if($registrationUrl)<p class="gs-login-register">Don't have an account?<a href="{{ $registrationUrl }}">Create Account</a></p>@endif
        @if($showPortalLinks)
        <nav class="gs-login-portals" aria-label="Other portal sign-in options">
            <div class="gs-login-links">
                @foreach(['teacher' => 'Teacher', 'student' => 'Student', 'guardian' => 'Guardian'] as $portal => $label)
                    <a href="{{ route('portal.login', ['portal' => $portal]) }}">{{ $label }}</a>
                @endforeach
            </div>
        </nav>
        @else
            <nav class="gs-login-portals" aria-label="Sign-in options"><div class="gs-login-links"><a href="{{ route('signin') }}">Back to Staff sign in</a></div></nav>
        @endif
        </div>
    </section>
</main>
<script>
(() => {
    const button = document.getElementById('signin-password-toggle');
    const password = document.getElementById('signin-password');
    if (!button || !password) return;
    button.hidden = false;
    button.addEventListener('click', () => {
        const show = password.type === 'password';
        password.type = show ? 'text' : 'password';
        button.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
        button.setAttribute('aria-pressed', String(show));
        button.querySelector('[data-password-slash]').toggleAttribute('hidden', !show);
    });
})();
</script>
@endsection
