@extends('layouts.clean')

@section('clean')

    @include('layouts.header')

    <main class="flex w-full flex-1 flex-col min-h-0">
        @yield('content')
    </main>

@endsection
