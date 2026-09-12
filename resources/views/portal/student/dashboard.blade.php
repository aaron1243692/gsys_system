@extends('portal.layout')
@section('title', 'Dashboard')
@section('portal-content')
@php($student = auth('student')->user())
<div class="gs-hero"><div><p class="gs-eyebrow">Student Dashboard</p><h1>Hello, {{ $student->name ?: $student->username }}.</h1><p class="gs-muted">Your student information and approved-grade shortcuts.</p></div><div class="gs-hero-mark"><img src="{{ asset('icons/backpack.png') }}" alt=""></div></div>
<div class="gs-card gs-section"><div class="gs-card-body"><dl class="gs-context"><div><dt>Student Number</dt><dd>Not supplied</dd></div><div><dt>Grade Level</dt><dd>Not supplied</dd></div><div><dt>Section</dt><dd>Not supplied</dd></div><div><dt>School Year</dt><dd>Not supplied</dd></div></dl></div></div>
<div class="gs-stats">@include('portal.partials.stat', ['label'=>'Grades Available','value'=>'—','hint'=>'Open My Grades','icon'=>'book'])@include('portal.partials.stat', ['label'=>'Subjects','value'=>'—','hint'=>'Enrollment summary not supplied','icon'=>'stack-of-books'])@include('portal.partials.stat', ['label'=>'Current Quarter','value'=>'—','hint'=>'No active quarter supplied','icon'=>'schedule'])@include('portal.partials.stat', ['label'=>'Account','value'=>'Active','hint'=>'Signed in to Student Portal','icon'=>'user'])</div>
<div class="gs-actions"><a class="gs-btn gs-btn-primary" href="{{ route('student.grades') }}">View Grades</a><a class="gs-btn" href="{{ route('student.subjects') }}">View Subjects</a></div>
@endsection
