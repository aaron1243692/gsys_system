@extends('portal.layout')
@section('title', 'Profile')
@section('portal-content')
@php($identity = auth($portal)->user())
@php($name = $identity->name ?: $identity->username)
@include('portal.partials.page-header', ['section'=>ucfirst($portal),'heading'=>'Profile','description'=>'Personal and account information for your portal.'])
<div class="gs-card"><div class="gs-card-body"><div class="gs-card-top"><span class="gs-avatar gs-avatar-lg">{{ mb_strtoupper(mb_substr($name,0,1)) }}</span><div><h2>{{ $name }}</h2><span class="gs-badge">{{ ucfirst($portal) }}</span></div></div><dl class="gs-context">@if($portal === 'student')<div><dt>Student Number</dt><dd>Not supplied</dd></div>@endif<div><dt>Name</dt><dd>{{ $name }}</dd></div><div><dt>Username</dt><dd>{{ $identity->username }}</dd></div><div><dt>Email</dt><dd>{{ $identity->email ?: 'Not provided' }}</dd></div></dl><p class="gs-footnote">Profile fields are read-only in this frontend phase. Contact the school for corrections or account assistance.</p></div></div>
<section class="gs-section" style="margin-top:24px"><div class="gs-section-heading"><h2>Account Settings</h2></div><div class="gs-card">@include('portal.partials.empty', ['icon'=>'user','heading'=>'Account settings are not available yet','description'=>'Password and profile updates require future backend support.'])</div></section>
@endsection
