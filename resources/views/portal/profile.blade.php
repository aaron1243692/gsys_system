@extends('portal.layout')
@section('title', 'Profile')
@section('portal-content')
@php($name = $portal === 'student' ? ($identity->student?->info?->name ?? $identity->name ?? $identity->username) : ($identity->name ?: $identity->username))
@include('portal.partials.page-header', ['section'=>ucfirst($portal),'heading'=>'Profile','description'=>'Update safe contact details and password.'])
<div class="gs-card gs-section"><div class="gs-card-body"><div class="gs-card-top"><span class="gs-avatar gs-avatar-lg">{{ mb_strtoupper(mb_substr($name,0,1)) }}</span><div><h2>{{ $name }}</h2><span class="gs-badge">{{ ucfirst($portal) }}</span></div></div><dl class="gs-context">@if($portal === 'student')<div><dt>Student Number</dt><dd>{{ $identity->student?->student_number }}</dd></div>@endif<div><dt>Username</dt><dd>{{ $identity->username }}</dd></div><div><dt>Status</dt><dd>{{ $identity->status }}</dd></div></dl></div></div>
<form method="POST" action="{{ route($portal.'.profile.update') }}" class="gs-card">
    @csrf
    <div class="gs-card-body">
        @if(session('success'))<p class="gs-alert">{{ session('success') }}</p>@endif
        @if ($errors->any())<p class="gs-error">{{ $errors->first() }}</p>@endif
        <div class="gs-grid">
            <label class="gs-field">Email<input type="email" name="email" value="{{ old('email', $identity->email) }}" required></label>
            @if(in_array($portal, ['student','guardian'], true))
                <label class="gs-field">Contact<input name="contact" value="{{ old('contact', $identity->contact) }}"></label>
                <label class="gs-field gs-field-wide">Address<textarea name="address" rows="3">{{ old('address', $identity->address) }}</textarea></label>
            @endif
            <label class="gs-field">Current Password<input type="password" name="current_password" required autocomplete="current-password"></label>
            <label class="gs-field">New Password<input type="password" name="password" autocomplete="new-password"></label>
            <label class="gs-field">Confirm New Password<input type="password" name="password_confirmation" autocomplete="new-password"></label>
        </div>
        <div class="gs-actions"><button class="gs-btn gs-btn-primary">Save Profile</button></div>
    </div>
</form>
@endsection
