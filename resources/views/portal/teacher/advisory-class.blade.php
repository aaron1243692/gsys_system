@extends('portal.layout')
@section('title', 'My Advisory Class')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Teacher','heading'=>'My Advisory Class','description'=>'View students in the class or section assigned to you as adviser.'])
@foreach($classes as $class)
<section class="gs-section">
    <div class="gs-section-heading"><div><h2>{{ $class->name }}</h2><p class="gs-muted gs-small">{{ $class->gradeLevel?->name }} &middot; SY {{ $class->academicYear?->name }}</p></div><span class="gs-badge">{{ ($students[$class->id] ?? collect())->count() }} students</span></div>
    <div class="gs-card"><div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>Student No.</th><th>Student Name</th></tr></thead><tbody>@forelse($students[$class->id] ?? [] as $studentInfo)<tr><td>{{ $studentInfo->student?->student_number ?? '-' }}</td><td>{{ $studentInfo->name }}</td></tr>@empty<tr><td colspan="2">No admitted students are enrolled in this advisory class.</td></tr>@endforelse</tbody></table></div></div>
</section>
@endforeach
<p class="gs-muted gs-small">Advisory responsibility does not grant permission to encode subject grades. Grade entry requires a separate subject teaching load.</p>
@endsection
