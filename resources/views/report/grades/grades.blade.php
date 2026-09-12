@extends('layouts.app')
@section('title', 'Grades')
@section('content')
    <section class="w-full px-4 py-5">
        <p class="text-sm font-semibold text-blue-700">Reports</p>
        <h1 class="mb-4 text-3xl font-bold">Grades</h1>
        @if($errors->any())<p role="alert" class="mb-4 text-red-700">{{ $errors->first() }}</p>@endif
        @include('report.grades.table', ['adminReport' => true])
    </section>
@endsection
