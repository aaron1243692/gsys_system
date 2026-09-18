@extends('portal.layout')
@section('title', 'Dashboard')
@section('portal-content')
@php($info = $student->info)
<div class="gs-hero"><div><p class="gs-eyebrow">Student Dashboard</p><h1>Hello, {{ $info?->name ?? $student->username }}.</h1><p class="gs-muted">Approved grades and current enrollment details.</p></div><div class="gs-hero-mark"><img src="{{ asset('icons/backpack.png') }}" alt=""></div></div>
<div class="gs-card gs-section"><div class="gs-card-body"><dl class="gs-context"><div><dt>Student Number</dt><dd>{{ $student->student_number }}</dd></div><div><dt>Grade Level</dt><dd>{{ $info?->gradeLevel?->name ?? 'Not assigned' }}</dd></div><div><dt>Section</dt><dd>{{ $info?->schoolClass?->name ?? 'Not assigned' }}</dd></div><div><dt>School Year</dt><dd>{{ $info?->academicYear?->name ?? 'Not assigned' }}</dd></div><div><dt>Class Adviser</dt><dd>{{ $info?->schoolClass?->adviser?->name ?? 'Not assigned' }}</dd></div></dl></div></div>
<div class="gs-stats">@include('portal.partials.stat', ['label'=>'Approved Grades','value'=>$gradeCount,'hint'=>'Visible after staff approval','icon'=>'book'])@include('portal.partials.stat', ['label'=>'Account','value'=>$student->status,'hint'=>'Portal access status','icon'=>'user'])</div>
<div class="gs-actions"><a class="gs-btn gs-btn-primary" href="{{ route('student.grades') }}">View Grades</a><a class="gs-btn" href="{{ route('student.subjects') }}">View Subjects</a></div>
@endsection
