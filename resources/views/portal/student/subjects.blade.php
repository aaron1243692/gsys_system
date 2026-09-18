@extends('portal.layout')
@section('title', 'Subjects')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Student','heading'=>'Subjects','description'=>'Subjects and schedules for your enrolled class and school year.'])
@if($schoolClass)<div class="gs-card gs-section"><div class="gs-card-body"><dl class="gs-context"><div><dt>Class / Section</dt><dd>{{ $schoolClass->name }}</dd></div><div><dt>School Year</dt><dd>{{ $schoolClass->academicYear?->name }}</dd></div><div><dt>Class Adviser</dt><dd>{{ $schoolClass->adviser?->name ?? 'Not assigned' }}</dd></div></dl></div></div>@endif
<div class="gs-card"><div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>Subject</th><th>Teacher</th><th>Schedule</th></tr></thead><tbody>
@forelse($schoolClass?->classSubjects ?? [] as $classSubject)
    @if($classSubject->subject)
    <tr><td>{{ $classSubject->subject->name }}</td><td>{{ $classSubject->teacher?->name ?? 'Not assigned' }}</td><td>
        @forelse($schoolClass->classSchedules->where('subject_id', $classSubject->sub_id) as $schedule)
            <div>{{ $schedule->day }} {{ \Carbon\Carbon::parse($schedule->time_from)->format('g:i A') }}–{{ \Carbon\Carbon::parse($schedule->time_to)->format('g:i A') }}{{ $schedule->room ? ' · '.$schedule->room->name : '' }}</div>
        @empty No schedule @endforelse
    </td></tr>
    @endif
@empty<tr><td colspan="3">No subjects are available for your current class.</td></tr>@endforelse
</tbody></table></div></div>
@endsection
