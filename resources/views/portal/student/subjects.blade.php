@extends('portal.layout')
@section('title', 'Subjects')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Student','heading'=>'Subjects','description'=>'Subjects assigned to your current class.'])
<div class="gs-card"><div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>Subject</th><th>Teacher</th></tr></thead><tbody>@forelse($schoolClass?->classSubjects ?? [] as $classSubject)<tr><td>{{ $classSubject->subject?->name }}</td><td>{{ $classSubject->subject?->teacher?->name ?? 'Not assigned' }}</td></tr>@empty<tr><td colspan="2">No subjects are available for your current class.</td></tr>@endforelse</tbody></table></div></div>
@endsection
