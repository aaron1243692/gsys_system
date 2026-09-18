@extends('portal.layout')
@section('title', 'Child Academic Record')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Guardian / My Children','heading'=>'Academic Record','description'=>$student->info?->name ?? $student->username,'backUrl'=>route('guardian.children'),'backLabel'=>'My Children'])
<div class="gs-card gs-section"><div class="gs-card-body">
    <dl class="gs-context"><div><dt>Student</dt><dd>{{ $student->info?->name ?? $student->username }}</dd></div><div><dt>Student Number</dt><dd>{{ $student->student_number }}</dd></div></dl>
    <form method="GET" class="gs-toolbar"><label class="gs-field">School Year<select name="academic_year_id" onchange="this.form.submit()">@foreach($years as $year)<option value="{{ $year->id }}" @selected($yearId === $year->id)>{{ $year->name }}</option>@endforeach</select></label><button class="gs-btn">View Year</button></form>
</div></div>
@forelse($classes as $class)
    <section class="gs-section"><div class="gs-section-heading"><h2>{{ $class->name }}</h2><span class="gs-badge">{{ $class->academicYear?->name }}</span></div>
    <div class="gs-card"><div class="gs-card-body"><dl class="gs-context"><div><dt>Grade Level</dt><dd>{{ $class->gradeLevel?->name ?? 'Not assigned' }}</dd></div><div><dt>Class Adviser</dt><dd>{{ $class->adviser?->name ?? 'Not assigned' }}</dd></div></dl></div>
    @php
        $classGrades = $grades->where('class_id', $class->id);
        $loads = $class->classSubjects->filter(fn ($load) => $load->subject);
        $subjectIds = $loads->pluck('sub_id');
        $rows = $loads->map(fn ($load) => ['name'=>$load->subject->name, 'teacher'=>$load->teacher?->name, 'grades'=>$classGrades->where('subject_id', $load->sub_id)]);
        foreach ($classGrades->whereNotIn('subject_id', $subjectIds)->groupBy('subject_id') as $subjectGrades) {
            $rows->push(['name'=>$subjectGrades->first()->subject_name, 'teacher'=>$subjectGrades->first()->teacher_name, 'grades'=>$subjectGrades]);
        }
    @endphp
    <div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>Subject</th><th>Teacher</th><th>Q1</th><th>Q2</th><th>Q3</th></tr></thead><tbody>
    @forelse($rows as $row)<tr><td>{{ $row['name'] }}</td><td>{{ $row['teacher'] ?? 'Not assigned' }}</td>@foreach([1,2,3] as $quarter)<td>@if(($value = $row['grades']->firstWhere('quarter', $quarter)?->grade) !== null){{ (float) $value }}@else—@endif</td>@endforeach</tr>
    @empty<tr><td colspan="5">No subjects or approved grades for this class.</td></tr>@endforelse
    </tbody></table></div></div></section>
@empty
    <div class="gs-card gs-section"><div class="gs-card-body">No academic record is available for this school year.</div></div>
@endforelse
@endsection
