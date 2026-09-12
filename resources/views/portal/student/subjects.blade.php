@extends('portal.layout')
@section('title', 'Subjects')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Student','heading'=>'Subjects','description'=>'Your enrolled subjects will be listed on this dedicated page.'])
<div class="gs-card">@include('portal.partials.empty', ['icon'=>'stack-of-books','heading'=>'Subject enrollment is not supplied','description'=>'This page is ready to display authorized enrollment data when the backend provides it.'])</div>
@endsection
