@extends('layouts.app')
@section('title', 'Grade Approval')
@section('content')
@include('portal.partials.styles')
<div class="gs-portal gs-approval-page" style="padding:24px" data-approval-app>
    <div class="gs-page-header"><div><p class="gs-eyebrow">Reports / Grades</p><h1>Grade Approval</h1><p>Review final quarterly grades as a complete grade sheet.</p></div></div>
    <p class="gs-alert">Frontend demonstration using sample grade sheets. Approve and Return change this page only; no official records or student visibility are changed.</p>
    <div class="gs-stats" style="grid-template-columns:repeat(3,minmax(0,1fr))">@foreach(['SUBMITTED' => 'Pending Review', 'APPROVED' => 'Approved', 'RETURNED' => 'Returned'] as $status => $label)<div class="gs-stat"><p>{{ $label }}</p><strong data-count="{{ $status }}">0</strong><small>Sample sheets</small></div>@endforeach</div>
    <section data-approval-list>
        <form class="gs-card gs-section" data-approval-filters><div class="gs-toolbar">
            @foreach(['year' => 'School Year', 'quarter' => 'Quarter', 'level' => 'Grade Level', 'className' => 'Class', 'teacher' => 'Teacher', 'status' => 'Status'] as $key => $label)<label class="gs-field">{{ $label }}<select name="{{ $key }}"><option value="">All</option></select></label>@endforeach
            <button class="gs-btn gs-btn-primary">Apply</button><button class="gs-btn" type="reset">Reset</button>
            <label class="gs-field gs-search">Search<input type="search" name="search" placeholder="Class, subject, or teacher"></label>
        </div></form>
        <div class="gs-card"><div class="gs-table-wrap" tabindex="0" role="region" aria-label="Grade approval queue"><table class="gs-table"><thead><tr>@foreach(['Teacher','Class','Subject','Quarter','Students','Submitted','Status','Action'] as $label)<th scope="col">{{ $label }}</th>@endforeach</tr></thead><tbody data-approval-rows></tbody></table></div></div>
    </section>
    <section data-review-panel hidden tabindex="-1">
        <div class="gs-section-heading"><h2>Review Grade Sheet</h2><button class="gs-btn" type="button" data-back-list>Back to Grade Approval</button></div>
        <div class="gs-card gs-section"><div class="gs-card-body"><dl class="gs-context" data-review-context></dl><p class="gs-alert gs-alert-warning" data-review-history hidden style="margin-top:18px"></p></div></div>
        <div class="gs-card"><div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>No.</th><th>Student ID</th><th>Student Name</th><th>Final Grade</th></tr></thead><tbody data-review-students></tbody></table></div><div class="gs-savebar"><button type="button" class="gs-btn" data-return-open>Return for Correction</button><button type="button" class="gs-btn gs-btn-primary" data-approve-open>Approve Grade Sheet</button></div></div>
        <p class="gs-alert" data-review-feedback role="status"></p>
    </section>
    <dialog class="gs-dialog" data-approve-dialog aria-labelledby="approve-title"><div class="gs-dialog-head"><h2 id="approve-title">Approve Grade Sheet?</h2></div><div class="gs-card-body"><p data-approve-summary></p><p style="margin-top:14px">Approved grades will become official and visible to students and their authorized guardians when the approval backend is connected.</p><p class="gs-footnote">This demonstration does not publish grades.</p><div class="gs-actions" style="justify-content:flex-end;margin-top:20px"><button type="button" class="gs-btn" data-cancel-approval>Cancel</button><button type="button" class="gs-btn gs-btn-primary" data-confirm-approval>Approve</button></div></div></dialog>
    <dialog class="gs-dialog" data-return-dialog aria-labelledby="return-title"><div class="gs-dialog-head"><h2 id="return-title">Return Grade Sheet</h2></div><form class="gs-card-body" data-return-form><p data-return-summary></p><label class="gs-field" style="margin:18px 0">Reason for return<textarea name="reason" required maxlength="1000" rows="4" placeholder="Explain which grades need correction"></textarea></label><div class="gs-actions" style="justify-content:flex-end"><button type="button" class="gs-btn" data-cancel-approval>Cancel</button><button class="gs-btn gs-btn-primary">Return to Teacher</button></div></form></dialog>
    <details style="margin-top:28px"><summary class="gs-btn">Existing class-subject records</summary><p class="gs-footnote">Assignments supplied by the existing backend. Approval status is not available.</p><form method="GET" class="gs-toolbar"><label class="gs-field">Search assignments<input name="search" value="{{ $search }}"></label><button class="gs-btn">Search</button></form><div class="gs-card"><div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>Class</th><th>Subject</th><th>Teacher</th><th>School Year</th></tr></thead><tbody>@forelse($approvals as $record)<tr><td>{{ $record->class_name }}</td><td>{{ $record->subject_name }}</td><td>{{ $record->teacher_name ?? 'Not assigned' }}</td><td>{{ $record->academic_year_name ?? 'Not available' }}</td></tr>@empty<tr><td colspan="4">No matching assignments.</td></tr>@endforelse</tbody></table></div></div>@include('portal.partials.pagination', ['paginator' => $approvals])</details>
</div>
<script src="{{ asset('js/grade-approval.js') }}" defer></script>
@endsection
