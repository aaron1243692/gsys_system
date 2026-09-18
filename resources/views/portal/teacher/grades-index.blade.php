@extends('portal.layout')
@section('title', 'Grades')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Teacher','heading'=>'Grades','description'=>'Open a grade sheet for one of your assigned subject teaching loads.'])
<section class="gs-section"><div class="gs-section-heading"><div><h2>My Teaching Loads</h2><p class="gs-muted gs-small">Only your assigned subjects appear here.</p></div><span class="gs-badge">{{ $loads->count() }} {{ $loads->count() === 1 ? 'load' : 'loads' }}</span></div>
<div class="gs-card"><div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>Subject</th><th>Class / Section</th><th>School Year</th><th>Grade Entry</th></tr></thead><tbody>
@forelse($loads as $load)
<tr><td>{{ $load->subject->name }}</td><td>{{ $load->schoolClass->name }}</td><td>{{ $load->schoolClass->academicYear?->name ?? 'Not assigned' }}</td><td>@if($load->schoolClass->acady_id)<a class="gs-btn gs-btn-primary" href="{{ route('teacher.grades', $load) }}">Open Grade Sheet</a>@else School year required @endif</td></tr>
@empty<tr><td colspan="4">No subjects assigned yet.</td></tr>@endforelse
</tbody></table></div></div></section>
<div class="gs-actions"><a class="gs-btn" href="{{ route('teacher.subjects') }}">View My Subjects</a><a class="gs-btn" href="{{ route('teacher.history') }}">View Grade History</a></div>
@endsection
