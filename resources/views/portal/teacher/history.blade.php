@extends('portal.layout')
@section('title', 'Grade History')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Teacher / Grades','heading'=>'Grade History','description'=>'Submitted, returned, and approved grade sheets will appear here.'])
<div class="gs-card">@include('portal.partials.empty', ['icon'=>'folder','heading'=>'Grade history is not available yet','description'=>'This separate page is ready for grade-sheet workflow data from the future backend.'])</div>
@endsection
