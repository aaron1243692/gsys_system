@extends('layouts.app')
@section('title', 'Grade Approval')
@section('content')
@include('portal.partials.styles')
<div class="gs-portal gs-approval-page" style="padding:24px">
    <div class="gs-page-header"><div><p class="gs-eyebrow">Reports / Grades</p><h1>Grade Approval</h1><p>Review submitted grade sheets before students and guardians can see them.</p></div></div>
    @if(session('success'))<p class="gs-alert">{{ session('success') }}</p>@endif
    <form method="GET" class="gs-card gs-section"><div class="gs-toolbar"><label class="gs-field">Quarter<select name="quarter"><option value="">All</option>@foreach([1,2,3] as $q)<option value="{{ $q }}" @selected(request('quarter')==$q)>Q{{ $q }}</option>@endforeach</select></label><label class="gs-field">Status<select name="status"><option value="">All</option>@foreach(['DRAFT','SUBMITTED','RETURNED','APPROVED'] as $status)<option value="{{ $status }}" @selected(request('status')===$status)>{{ $status }}</option>@endforeach</select></label><button class="gs-btn gs-btn-primary">Apply</button></div></form>
    <div class="gs-card"><div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>Teacher</th><th>Class</th><th>Subject</th><th>Quarter</th><th>Status</th><th>Submitted</th><th>Action</th></tr></thead><tbody>@forelse($sheets as $sheet)<tr><td>{{ $sheet->teacher_name }}</td><td>{{ $sheet->class_name }}</td><td>{{ $sheet->subject_name }}</td><td>Q{{ $sheet->quarter }}</td><td><span class="gs-badge" data-status="{{ $sheet->status }}">{{ $sheet->status }}</span></td><td>{{ $sheet->submitted_at?->format('M d, Y h:i A') ?? '-' }}</td><td><a class="gs-btn" href="{{ route('report.grades.approval.show', $sheet) }}">Review</a></td></tr>@empty<tr><td colspan="7">No grade sheets found.</td></tr>@endforelse</tbody></table></div></div>
    @include('portal.partials.pagination', ['paginator' => $sheets])
</div>
@endsection
