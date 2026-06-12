@extends('layouts.clean')

@section('clean')

    @include('layouts.header')

    <main class="flex w-full flex-1 flex-col min-h-0 lg:pl-72">
        @yield('content')
    </main>

@endsection
