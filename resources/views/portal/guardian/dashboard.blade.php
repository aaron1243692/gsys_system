@extends('portal.layout')
@section('title', 'Dashboard')
@section('portal-content')
@php($guardian = auth('guardian')->user())
<div class="gs-hero"><div><p class="gs-eyebrow">Guardian Dashboard</p><h1>Welcome, {{ $guardian->name ?: $guardian->username }}.</h1><p class="gs-muted">Open your authorized children and approved-grade pages.</p></div><div class="gs-hero-mark"><img src="{{ asset('icons/adult.png') }}" alt=""></div></div>
<div class="gs-stats">@include('portal.partials.stat', ['label'=>'Linked Children','value'=>'—','hint'=>'Open My Children for the list','icon'=>'children'])@include('portal.partials.stat', ['label'=>'Grades Available','value'=>'—','hint'=>'Approved grades only','icon'=>'book'])@include('portal.partials.stat', ['label'=>'School Year','value'=>'—','hint'=>'Shown with child records','icon'=>'schedule'])@include('portal.partials.stat', ['label'=>'Account','value'=>'Active','hint'=>'Signed in to Guardian Portal','icon'=>'user'])</div>
<div class="gs-card"><div class="gs-card-body"><h2>Children Overview</h2><p class="gs-muted">Linked-child details are kept on the dedicated My Children page.</p><div class="gs-actions" style="margin-top:18px"><a class="gs-btn gs-btn-primary" href="{{ route('guardian.children') }}">View All Children</a><a class="gs-btn" href="{{ route('guardian.grades.index') }}">Open Grades</a></div></div></div>
@endsection
