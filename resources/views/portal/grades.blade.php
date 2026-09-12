@extends('portal.layout')
@section('title', $portal === 'student' ? 'My Grades' : 'Child Grades')
@section('portal-content')
@php
    $visibleRecords = $grades->getCollection();
    $firstRecord = $visibleRecords->first();
    $studentName = $firstRecord?->student_name ?? ($student->relationLoaded('info') ? $student->info?->name : null) ?? $student->username;
@endphp
@if($portal === 'student')
    @include('portal.partials.page-header', ['section'=>'Student','heading'=>'My Grades','description'=>'Approved Quarter 1, Quarter 2, and Quarter 3 final grades.'])
    <div class="gs-card gs-section"><div class="gs-card-body"><dl class="gs-context"><div><dt>Student</dt><dd>{{ $studentName }}</dd></div><div><dt>Student ID</dt><dd>{{ $student->id }}</dd></div><div><dt>Class</dt><dd>{{ $firstRecord?->class_name ?? 'Not available' }}</dd></div><div><dt>School Year</dt><dd>{{ $firstRecord?->academic_year_name ?? 'Not available' }}</dd></div></dl></div></div>
@else
    @include('portal.partials.page-header', ['section'=>'Guardian / Grades','heading'=>'Child Grades','description'=>'Approved quarterly grades for '.$studentName.'.','backUrl'=>route('guardian.children'),'backLabel'=>'My Children'])
    <div class="gs-card gs-section"><div class="gs-card-body"><dl class="gs-context"><div><dt>Student</dt><dd>{{ $studentName }}</dd></div><div><dt>Grade Level</dt><dd>{{ $firstRecord?->grade_level_name ?? 'Not available' }}</dd></div><div><dt>Section</dt><dd>{{ $firstRecord?->class_name ?? 'Not available' }}</dd></div><div><dt>School Year</dt><dd>{{ $firstRecord?->academic_year_name ?? 'Not available' }}</dd></div></dl></div></div>
@endif
<section class="gs-section">
    <div class="gs-section-heading"><div><h2>{{ $portal === 'student' ? 'My Grades' : 'Quarterly Grades' }}</h2><p class="gs-muted gs-small">Only approved final grades are intended to appear.</p></div><span class="gs-badge gs-badge-muted">Q1 / Q2 / Q3</span></div>
    <p class="gs-alert">Approval information is not connected yet. Unavailable grades remain hidden.</p>
    @include('portal.partials.grade-table')
</section>
@endsection
