@extends('portal.layout')
@section('title', 'Grades')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Teacher','heading'=>'Grades','description'=>'Start manual grade entry from one of your assigned class and subject combinations.'])
<div class="gs-card"><div class="gs-card-body"><h2>Open a Grade Sheet</h2><p class="gs-muted">Grade entry requires an assigned class and subject. Select one from My Classes, then choose Quarter 1, 2, or 3.</p><div class="gs-actions" style="margin-top:18px"><a class="gs-btn gs-btn-primary" href="{{ route('teacher.classes') }}">Go to My Classes</a><a class="gs-btn" href="{{ route('teacher.history') }}">View Grade History</a></div></div></div>
@endsection
