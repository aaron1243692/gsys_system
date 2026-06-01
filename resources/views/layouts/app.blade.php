@extends('layouts.clean')

@section('clean')

    @include('layouts.header')

    <main class="w-full flex-1">
        @yield('content')
    </main>

@endsection
