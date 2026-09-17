@extends('layouts.app')
@section('title', 'Grade Encoding Schedule')
@section('content')
@include('portal.partials.styles')
<div class="gs-portal" style="padding:24px">
    <div class="gs-page-header"><div><p class="gs-eyebrow">Configuration</p><h1>Grade Encoding Schedule</h1><p>Set Q1 to Q3 encoding windows by school year.</p></div></div>
    @if(session('success'))<p class="gs-alert">{{ session('success') }}</p>@endif
    @if($errors->any())<p class="gs-error">{{ $errors->first() }}</p>@endif
    <form method="POST" action="{{ route('configuration.grade-encoding-schedule.store') }}" class="gs-card gs-section"><div class="gs-card-body">@csrf<div class="gs-grid"><label class="gs-field">School Year<select name="academic_year_id" required>@foreach($years as $year)<option value="{{ $year->id }}">{{ $year->name }}</option>@endforeach</select></label><label class="gs-field">Quarter<select name="quarter" required>@foreach([1,2,3] as $quarter)<option value="{{ $quarter }}">Quarter {{ $quarter }}</option>@endforeach</select></label><label class="gs-field">Opens At<input type="datetime-local" name="opens_at" required></label><label class="gs-field">Closes At<input type="datetime-local" name="closes_at" required></label></div><div class="gs-actions"><button class="gs-btn gs-btn-primary">Save Schedule</button></div></div></form>
    <div class="gs-card"><div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>School Year</th><th>Quarter</th><th>Opens</th><th>Closes</th><th>Status</th></tr></thead><tbody>@forelse($schedules as $schedule)<tr><td>{{ $schedule->academicYear?->name }}</td><td>Q{{ $schedule->quarter }}</td><td>{{ $schedule->opens_at->format('M d, Y h:i A') }}</td><td>{{ $schedule->closes_at->format('M d, Y h:i A') }}</td><td><span class="gs-badge" data-status="{{ $schedule->status }}">{{ $schedule->status }}</span></td></tr>@empty<tr><td colspan="5">No schedules configured.</td></tr>@endforelse</tbody></table></div></div>
</div>
@endsection
