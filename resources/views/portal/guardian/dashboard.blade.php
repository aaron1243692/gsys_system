@extends('portal.layout')
@section('title', 'Dashboard')
@section('portal-content')
@php($guardian = auth('guardian')->user())
<div class="gs-hero"><div><p class="gs-eyebrow">Guardian Dashboard</p><h1>Welcome, {{ $guardian->name ?: $guardian->username }}.</h1><p class="gs-muted">Authorized children and approved grades.</p></div><div class="gs-hero-mark"><img src="{{ asset('icons/adult.png') }}" alt=""></div></div>
<div class="gs-stats">@include('portal.partials.stat', ['label'=>'My Children','value'=>$childCount,'hint'=>'Linked by school staff','icon'=>'children'])@include('portal.partials.stat', ['label'=>'Approved Grades','value'=>$gradeCount,'hint'=>'Across linked children','icon'=>'book'])</div>
<section class="gs-section"><div class="gs-section-heading"><h2>My Children</h2><a class="gs-btn" href="{{ route('guardian.children') }}">View All Children</a></div><div class="gs-card-grid">
@forelse($children as $child)
<article class="gs-card"><div class="gs-card-body"><h3>{{ $child->info?->name ?? $child->username }}</h3><p>Student No. {{ $child->student_number }}</p><p>{{ $child->info?->gradeLevel?->name ?? 'Grade unavailable' }} · {{ $child->info?->schoolClass?->name ?? 'Class unavailable' }}</p><p>SY {{ $child->info?->academicYear?->name ?? 'Unavailable' }}</p><p>Adviser: {{ $child->info?->schoolClass?->adviser?->name ?? 'Not assigned' }}</p><p>Approved quarters: {{ $child->approvedQuarters->map(fn ($q) => 'Q'.$q)->join(', ') ?: 'None yet' }}</p></div><div class="gs-card-foot"><a class="gs-btn gs-btn-primary" href="{{ route('guardian.grades', $child) }}">View Academic Record</a></div></article>
@empty<div class="gs-card"><div class="gs-card-body">No children linked yet. Contact authorized school staff if a child should be linked to your account.</div></div>@endforelse
</div></section>
@endsection
