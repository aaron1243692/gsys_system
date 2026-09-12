@extends('portal.layout')
@section('title', 'Grade Entry')
@section('portal-content')
@include('portal.partials.page-header', ['section' => 'Teacher / Grades / '.$schoolClass->name.' / '.$subject->name, 'heading' => 'Grade Entry', 'description' => 'Record final quarter grades for your assigned subject.', 'backUrl' => route('teacher.classes'), 'backLabel' => 'My Classes'])
<div class="gs-card gs-section"><div class="gs-card-body"><dl class="gs-context"><div><dt>Class</dt><dd>{{ $schoolClass->name }}</dd></div><div><dt>Subject</dt><dd>{{ $subject->name }}</dd></div><div><dt>School Year</dt><dd>{{ $schoolClass->academicYear?->name ?? 'Not assigned' }}</dd></div><div><dt>Teacher</dt><dd>{{ auth('teacher')->user()->name }}</dd></div></dl></div></div>
<div class="gs-section-heading"><form method="GET" class="gs-actions"><label class="gs-field" for="quarter">Quarter<select id="quarter" name="quarter">@foreach([1,2,3] as $q)<option value="{{ $q }}" @selected($quarter === $q)>Quarter {{ $q }}</option>@endforeach</select></label><button class="gs-btn" style="align-self:end">Open</button></form></div>
<div class="gs-alert"><strong>Grade Encoding Schedule</strong><p>Scheduling is not connected yet. Existing grade access applies.</p><button type="button" class="gs-btn" data-open-dialog="schedule-preview-dialog">Preview quarter states</button></div>
<dialog id="schedule-preview-dialog" class="gs-dialog" style="width:min(850px,calc(100% - 32px))" aria-label="Grade encoding schedule preview"><div class="gs-dialog-head"><h2>Grade Encoding Schedule</h2><button type="button" class="gs-close" data-close-dialog aria-label="Close preview">&times;</button></div><div class="gs-card-body">@include('grading.schedule-preview', ['scheduleAdmin' => false])</div></dialog>
@include('grading.teacher-workflow')
@if($excluded > 0)<p role="alert" class="gs-alert gs-alert-warning">{{ $excluded }} admitted profile(s) have inconsistent placement or missing accounts. Ask administration to verify their class, grade level, and school year before encoding.</p>@endif
@unless($editable)<p class="gs-alert gs-alert-warning">This quarter is not editable.</p>@endunless
<div class="gs-card">
    <div class="gs-toolbar"><label class="gs-field gs-search">Search students<span class="gs-input-wrap"><img src="{{ asset('icons/magnifying-glass.png') }}" alt=""><input data-student-search type="search" placeholder="Search by name or student ID"></span></label><span class="gs-badge" style="align-self:center">Q{{ $quarter }}</span><span class="gs-muted gs-small" style="margin-left:auto;align-self:center"><span data-visible-count>{{ $students->count() }}</span> students shown</span></div>
    <form onsubmit="return false" method="POST" action="{{ route('teacher.grades.store', [$schoolClass, $subject]) }}" data-loading-label="Saving...">
        @csrf
        <input type="hidden" name="quarter" value="{{ $quarter }}"><input type="hidden" name="academic_year_id" value="{{ $schoolClass->acady_id }}">
        <div class="gs-table-wrap gs-manual-scroll" tabindex="0" role="region" aria-label="Student grade entry">
            <table class="gs-table gs-manual-table"><thead><tr><th scope="col">No.</th><th scope="col">Student ID</th><th scope="col">Student Name</th><th scope="col">Final Grade</th></tr></thead><tbody>
                @forelse($students->values() as $i => $student)
                    @php($record = $grades->get($student->student_id))
                    @php($submitted = collect(old('rows', []))->first(fn ($row) => (string) ($row['student_id'] ?? '') === (string) $student->student_id))
                    <tr data-student-row="{{ $student->name.' '.$student->student_id }}"><td class="gs-muted">{{ $i+1 }}<input type="hidden" name="rows[{{ $i }}][student_id]" value="{{ $student->student_id }}"></td><td class="gs-muted">{{ $student->student_id }}</td><td><strong>{{ $student->name }}</strong><small>{{ $record ? 'Grade recorded' : 'Awaiting grade' }}</small></td><td><input aria-label="{{ $student->name }} Q{{ $quarter }} grade" type="number" inputmode="decimal" step="0.01" min="{{ config('grading.minimum') }}" max="{{ config('grading.maximum') }}" name="rows[{{ $i }}][grade]" value="{{ $submitted ? ($submitted['grade'] ?? '') : $record?->grade }}" @disabled(!$editable) class="gs-grade-input" aria-describedby="grade-help @error('rows.'.$i.'.grade') grade-error-{{ $i }} @enderror" @error('rows.'.$i.'.grade') aria-invalid="true" @enderror placeholder=""><small data-grade-missing>Not encoded</small>@error('rows.'.$i.'.grade')<p id="grade-error-{{ $i }}" class="gs-error">{{ $message }}</p>@enderror<input type="hidden" aria-label="{{ $student->name }} remarks" name="rows[{{ $i }}][remarks]" maxlength="50" value="{{ $submitted ? ($submitted['remarks'] ?? '') : $record?->remarks }}" @disabled(!$editable)>@error('rows.'.$i.'.remarks')<p class="gs-error">{{ $message }}</p>@enderror</td></tr>
                @empty
                    <tr><td colspan="4">@include('portal.partials.empty', ['icon' => 'children', 'heading' => 'No eligible enrolled students.', 'description' => 'Students will appear once their admission and class placement are complete.'])</td></tr>
                @endforelse
                @if($students->isNotEmpty())<tr data-search-empty hidden><td colspan="4">@include('portal.partials.empty', ['icon' => 'magnifying-glass', 'heading' => 'No matching students', 'description' => 'Try a different name or student ID. Your entered grades are kept while filtering.'])</td></tr>@endif
            </tbody></table>
        </div>
        <input type="hidden" name="complete" value="1">
        <div class="gs-savebar"><p id="grade-help" class="gs-muted gs-small">Grades: {{ config('grading.minimum') }}?{{ config('grading.maximum') }} / Up to 2 decimal places<br>Missing grades stay blank. Search keeps all students in this sheet.</p><div class="gs-actions"><span data-missing-count class="gs-badge gs-badge-amber"></span><button type="button" class="gs-btn" data-draft-action disabled>Save Draft</button><button type="button" class="gs-btn gs-btn-primary" data-submit-sheet disabled>Submit Grade Sheet</button>@if($editable && $students->isNotEmpty())<button class="gs-btn gs-btn-primary" data-submit-button data-legacy-save hidden>Save Grades</button>@endif</div></div>
    </form>
</div>
<p data-workflow-feedback class="gs-alert" role="status">Draft and submission actions are frontend demonstrations only.</p>
<p class="gs-footnote">Enter final quarter grades only. Use Tab and Shift+Tab to move between students.</p>
@endsection
