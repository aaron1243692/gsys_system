@extends('portal.layout')
@section('title', 'Grades')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Guardian','heading'=>'Grades','description'=>'Choose an authorized linked child before viewing approved quarterly grades.'])
<div class="gs-card"><div class="gs-card-body"><h2>Select a Child</h2><p class="gs-muted">Each child has a separate grade page. Only authorized linked children can be opened.</p><a class="gs-btn gs-btn-primary" style="margin-top:18px" href="{{ route('guardian.children') }}">Go to My Children</a></div></div>
@endsection
