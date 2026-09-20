@extends('layouts.clean')
@php
    abort_unless(in_array($portal, ['student', 'guardian'], true), 404);
    $isStudent = $portal === 'student';
@endphp
@section('title', ucfirst($portal).' Registration')
@section('clean')
@include('portal.partials.public-styles')
<main class="gs-public">
    <div class="gs-public-shell">
        <header class="gs-public-head">
            <div><p>Cauayan City National High School</p><h1>{{ ucfirst($portal) }} Registration</h1></div>
            <a href="{{ route('portal.login', ['portal' => $portal]) }}">Sign In</a>
        </header>
        <div class="gs-public-body">
            <p class="gs-notice">Accounts are reviewed by school staff. Portal access starts only after activation.</p>
            @if ($errors->any())
                <div class="gs-error" role="alert">{{ $errors->first() }}</div>
            @endif
            <form id="registration-form" method="POST" action="{{ route('portal.register.store', ['portal' => $portal]) }}" class="gs-panel">
                @csrf
                <h2>{{ $isStudent ? 'Student Information' : 'Guardian Information' }}</h2>
                <div class="gs-grid">
                    <label class="gs-field">Full Name <span class="gs-required">Required</span><input name="name" value="{{ old('name') }}" required maxlength="150">@error('name')<span class="gs-error" role="alert">{{ $message }}</span>@enderror</label>
                    <label class="gs-field">Contact Number<input name="contact" value="{{ old('contact') }}" maxlength="100">@error('contact')<span class="gs-error" role="alert">{{ $message }}</span>@enderror</label>
                    <label class="gs-field gs-field-wide">Address<textarea name="address" rows="3" maxlength="255">{{ old('address') }}</textarea>@error('address')<span class="gs-error" role="alert">{{ $message }}</span>@enderror</label>
                    @if($isStudent)
                        <label class="gs-field">Date of Birth <span class="gs-required">Required</span><input type="date" name="birthdate" value="{{ old('birthdate') }}" required>@error('birthdate')<span class="gs-error" role="alert">{{ $message }}</span>@enderror</label>
                        <label class="gs-field">Gender <span class="gs-required">Required</span><select name="gender" required><option value="">Select</option><option @selected(old('gender')==='Female')>Female</option><option @selected(old('gender')==='Male')>Male</option></select>@error('gender')<span class="gs-error" role="alert">{{ $message }}</span>@enderror</label>
                        <label class="gs-field">Grade Level <span class="gs-required">Required</span><select name="grlvl_id" required><option value="">Select</option>@foreach($levels as $level)<option value="{{ $level->id }}" @selected(old('grlvl_id')==$level->id)>{{ $level->name }}</option>@endforeach</select>@error('grlvl_id')<span class="gs-error" role="alert">{{ $message }}</span>@enderror</label>
                        <label class="gs-field">School Year <span class="gs-required">Required</span><select name="acady_id" required><option value="">Select</option>@foreach($years as $year)<option value="{{ $year->id }}" @selected(old('acady_id')==$year->id)>{{ $year->name }}</option>@endforeach</select>@error('acady_id')<span class="gs-error" role="alert">{{ $message }}</span>@enderror</label>
                    @endif
                </div>
                <h2>Account Credentials</h2>
                <div class="gs-grid">
                    <label class="gs-field">Email <span class="gs-required">Required</span><input type="email" name="email" value="{{ old('email') }}" required maxlength="100">@error('email')<span class="gs-error" role="alert">{{ $message }}</span>@enderror</label>
                    <label class="gs-field">Username <span class="gs-required">Required</span><input name="username" value="{{ old('username') }}" required maxlength="100">@error('username')<span class="gs-error" role="alert">{{ $message }}</span>@enderror</label>
                    @include('portal.partials.registration-passwords')
                </div>
                <h2>Terms and Privacy</h2>
                <div class="gs-doc-links"><a href="{{ route('legal.terms') }}" target="_blank" rel="noopener">Read Terms of Use</a><a href="{{ route('legal.privacy') }}" target="_blank" rel="noopener">Read Privacy Notice</a></div>
                <label class="gs-check"><input type="checkbox" name="terms" value="1" required @checked(old('terms'))><span>I agree to the Terms of Use.</span>@error('terms')<span class="gs-error" role="alert">{{ $message }}</span>@enderror</label>
                <label class="gs-check"><input type="checkbox" name="privacy" value="1" required @checked(old('privacy'))><span>I acknowledge the Privacy Notice.</span>@error('privacy')<span class="gs-error" role="alert">{{ $message }}</span>@enderror</label>
                <div class="gs-actions"><a class="gs-btn" href="{{ route('portal.login', ['portal' => $portal]) }}">Cancel</a><button class="gs-btn gs-btn-primary">Submit Registration</button></div>
            </form>
        </div>
    </div>
</main>
<script>
(() => {
    const form = document.getElementById('registration-form');
    const button = form.querySelector('button:not([type="button"])');
    const label = button.textContent;
    let submitting = false;
    form.addEventListener('submit', event => {
        if (submitting) { event.preventDefault(); return; }
        submitting = true;
        button.disabled = true;
        button.textContent = 'Submitting...';
        form.setAttribute('aria-busy', 'true');
    });
    window.addEventListener('pageshow', () => {
        submitting = false;
        button.disabled = false;
        button.textContent = label;
        form.removeAttribute('aria-busy');
    });
})();
</script>
@endsection
