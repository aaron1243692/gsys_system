@extends('portal.layout')
@section('title', 'Grade History')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Teacher / Grades','heading'=>'Grade History','description'=>'Submitted, returned, and approved grade sheets.'])
<div class="gs-card"><div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>Class</th><th>Subject</th><th>Quarter</th><th>Status</th><th>Submitted</th><th>Reviewed</th></tr></thead><tbody>@forelse($sheets as $sheet)<tr><td>{{ $sheet->class_name }}</td><td>{{ $sheet->subject_name }}</td><td>Q{{ $sheet->quarter }}</td><td><span class="gs-badge" data-status="{{ $sheet->status }}">{{ $sheet->status }}</span></td><td>{{ $sheet->submitted_at?->format('M d, Y h:i A') ?? '-' }}</td><td>{{ $sheet->approved_at?->format('M d, Y h:i A') ?? $sheet->returned_at?->format('M d, Y h:i A') ?? '-' }}</td></tr>@empty<tr><td colspan="6">No grade sheet history yet.</td></tr>@endforelse</tbody></table></div></div>
@include('portal.partials.pagination', ['paginator' => $sheets])
@endsection
