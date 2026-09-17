@extends('portal.layout')
@section('title', 'Dashboard')
@section('portal-content')
@php($guardian = auth('guardian')->user())
<div class="gs-hero"><div><p class="gs-eyebrow">Guardian Dashboard</p><h1>Welcome, {{ $guardian->name ?: $guardian->username }}.</h1><p class="gs-muted">Authorized children and approved grades.</p></div><div class="gs-hero-mark"><img src="{{ asset('icons/adult.png') }}" alt=""></div></div>
<div class="gs-stats">@include('portal.partials.stat', ['label'=>'Verified Children','value'=>$childCount,'hint'=>'Staff-verified relationships','icon'=>'children'])@include('portal.partials.stat', ['label'=>'Approved Grades','value'=>$gradeCount,'hint'=>'Across verified children','icon'=>'book'])@include('portal.partials.stat', ['label'=>'Account','value'=>$guardian->status,'hint'=>'Portal access status','icon'=>'user'])</div>
<div class="gs-card"><div class="gs-card-body"><h2>Children Overview</h2><p class="gs-muted">Only verified child relationships can open grade records.</p><div class="gs-actions" style="margin-top:18px"><a class="gs-btn gs-btn-primary" href="{{ route('guardian.children') }}">View All Children</a><a class="gs-btn" href="{{ route('guardian.grades.index') }}">Open Grades</a></div></div></div>
@endsection
