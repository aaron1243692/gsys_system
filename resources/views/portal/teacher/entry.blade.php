@extends('portal.layout')
@section('title', 'Grade Entry')
@section('portal-content')
@include('portal.partials.page-header', ['section' => 'Teacher / Grades / '.$schoolClass->name.' / '.$subject->name, 'heading' => 'Grade Entry', 'description' => 'Record final quarter grades for your assigned subject.', 'backUrl' => route('teacher.classes'), 'backLabel' => 'My Classes'])
<div class="gs-card gs-section"><div class="gs-card-body"><dl class="gs-context"><div><dt>Class</dt><dd>{{ $schoolClass->name }}</dd></div><div><dt>Subject</dt><dd>{{ $subject->name }}</dd></div><div><dt>School Year</dt><dd>{{ $schoolClass->academicYear?->name ?? 'Not assigned' }}</dd></div><div><dt>Status</dt><dd><span class="gs-badge" data-status="{{ $sheet?->status ?? 'DRAFT' }}">{{ $sheet?->status ?? 'DRAFT' }}</span></dd></div></dl></div></div>
<div class="gs-section-heading"><form method="GET" class="gs-actions"><label class="gs-field" for="quarter">Quarter<select id="quarter" name="quarter">@foreach([1,2,3] as $q)<option value="{{ $q }}" @selected($quarter === $q)>Quarter {{ $q }}</option>@endforeach</select></label><button class="gs-btn" style="align-self:end">Open</button></form></div>
<div class="gs-alert">
    <strong>Grade Encoding Schedule</strong>
    @if($schedule)
        <p>Q{{ $quarter }} is {{ $schedule->status }} from {{ $schedule->opens_at->format('M d, Y h:i A') }} to {{ $schedule->closes_at->format('M d, Y h:i A') }}.</p>
    @else
        <p>No encoding schedule exists for this quarter.</p>
    @endif
    @if($sheet?->status === 'RETURNED')<p><strong>Returned:</strong> {{ $sheet->return_reason }} Correction deadline: {{ $sheet->correction_until?->format('M d, Y h:i A') }}</p>@endif
</div>
@if(session('success'))<p class="gs-alert">{{ session('success') }}</p>@endif
@if($errors->any())<p class="gs-error">{{ $errors->first() }}</p>@endif
@if($excluded > 0)<p role="alert" class="gs-alert gs-alert-warning">{{ $excluded }} admitted profile(s) have inconsistent placement or missing accounts. Ask administration to verify their class, grade level, and school year before encoding.</p>@endif
@unless($editable)<p class="gs-alert gs-alert-warning">This quarter is locked, submitted, approved, or outside the encoding/correction window.</p>@endunless
<div class="gs-card">
    <div class="gs-toolbar"><label class="gs-field gs-search">Search students<span class="gs-input-wrap"><img src="{{ asset('icons/magnifying-glass.png') }}" alt=""><input data-student-search type="search" placeholder="Search by name or student number"></span></label><span class="gs-badge" style="align-self:center">Q{{ $quarter }}</span><span class="gs-muted gs-small" style="margin-left:auto;align-self:center"><span data-visible-count>{{ $students->count() }}</span> students shown</span></div>
    <form method="POST" action="{{ route('teacher.grades.store', [$schoolClass, $subject]) }}" data-loading-label="Saving...">
        @csrf
        <input type="hidden" name="quarter" value="{{ $quarter }}"><input type="hidden" name="academic_year_id" value="{{ $schoolClass->acady_id }}"><input type="hidden" name="complete" value="1">
        <div class="gs-table-wrap gs-manual-scroll" tabindex="0" role="region" aria-label="Student grade entry">
            <table class="gs-table gs-manual-table"><thead><tr><th scope="col">No.</th><th scope="col">Student Number</th><th scope="col">Student Name</th><th scope="col">Final Grade</th></tr></thead><tbody>
                @forelse($students->values() as $i => $student)
                    @php($record = $grades->get($student->student_id))
                    @php($submitted = collect(old('rows', []))->first(fn ($row) => (string) ($row['student_id'] ?? '') === (string) $student->student_id))
                    <tr data-student-row="{{ $student->name.' '.$student->student?->student_number }}"><td class="gs-muted">{{ $i+1 }}<input type="hidden" name="rows[{{ $i }}][student_id]" value="{{ $student->student_id }}"></td><td class="gs-muted">{{ $student->student?->student_number }}</td><td><strong>{{ $student->name }}</strong><small>{{ $record ? 'Grade recorded' : 'Awaiting grade' }}</small></td><td><input aria-label="{{ $student->name }} Q{{ $quarter }} grade" type="number" inputmode="decimal" step="0.01" min="{{ config('grading.minimum') }}" max="{{ config('grading.maximum') }}" name="rows[{{ $i }}][grade]" value="{{ $submitted ? ($submitted['grade'] ?? '') : $record?->grade }}" @disabled(!$editable) class="gs-grade-input" @error('rows.'.$i.'.grade') aria-invalid="true" @enderror><input type="hidden" name="rows[{{ $i }}][remarks]" maxlength="50" value="{{ $submitted ? ($submitted['remarks'] ?? '') : $record?->remarks }}" @disabled(!$editable)>@error('rows.'.$i.'.grade')<p class="gs-error">{{ $message }}</p>@enderror</td></tr>
                @empty
                    <tr><td colspan="4">@include('portal.partials.empty', ['icon' => 'children', 'heading' => 'No eligible enrolled students.', 'description' => 'Students will appear once their admission and class placement are complete.'])</td></tr>
                @endforelse
                @if($students->isNotEmpty())<tr data-search-empty hidden><td colspan="4">@include('portal.partials.empty', ['icon' => 'magnifying-glass', 'heading' => 'No matching students', 'description' => 'Try a different name or student number.'])</td></tr>@endif
            </tbody></table>
        </div>
        <div class="gs-savebar"><p class="gs-muted gs-small">Grades: {{ config('grading.minimum') }} to {{ config('grading.maximum') }} / up to 2 decimal places.</p><div class="gs-actions"><button name="action" value="draft" class="gs-btn" @disabled(!$editable || $students->isEmpty())>Save Draft</button><button name="action" value="submit" class="gs-btn gs-btn-primary" @disabled(!$editable || $students->isEmpty())>Submit Grade Sheet</button></div></div>
    </form>
</div>
<p class="gs-footnote">Enter final quarter grades only. Submitted and approved sheets are read-only.</p>
@endsection
