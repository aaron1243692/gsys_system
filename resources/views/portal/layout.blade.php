@extends('layouts.clean')
@section('clean')
@include('portal.partials.styles')
@php
    $identity = auth($portal)->user();
    $displayName = $identity->name ?: $identity->username;
    $home = route($portal.'.home');
    $navItems = match ($portal) {
        'teacher' => [
            ['teacher.home', 'Dashboard', 'list'],
            ['teacher.classes', 'My Classes', 'stack-of-books'],
            ['teacher.grades.index', 'Grades', 'pencil', ['teacher.grades', 'teacher.grades.index']],
            ['teacher.history', 'Grade History', 'folder'],
            ['teacher.profile', 'Profile', 'user'],
        ],
        'student' => [
            ['student.home', 'Dashboard', 'list'],
            ['student.grades', 'My Grades', 'book'],
            ['student.subjects', 'Subjects', 'stack-of-books'],
            ['student.profile', 'Profile', 'user'],
        ],
        default => [
            ['guardian.home', 'Dashboard', 'list'],
            ['guardian.children', 'My Children', 'children'],
            ['guardian.grades.index', 'Grades', 'book', ['guardian.grades', 'guardian.grades.index']],
            ['guardian.profile', 'Profile', 'user'],
        ],
    };
@endphp
<div class="gs-portal">
    <a href="#portal-content" class="gs-skip">Skip to content</a>
    <div class="gs-overlay" data-portal-overlay></div>
    <aside id="portal-sidebar" class="gs-sidebar" aria-label="{{ ucfirst($portal) }} navigation">
        <button class="gs-sidebar-close" type="button" data-sidebar-close aria-label="Close navigation">&times;</button>
        <a class="gs-brand" href="{{ $home }}"><span class="gs-avatar">G</span><span><strong>GSYS</strong><small>School System</small></span></a>
        <div>
            <p class="gs-nav-label">{{ ucfirst($portal) }} workspace</p>
            <nav class="gs-nav">
                @foreach($navItems as $item)
                    @php([$routeName, $label, $icon] = $item)
                    @php($activeRoutes = $item[3] ?? [$routeName])
                    <a href="{{ route($routeName) }}" @if(request()->routeIs(...$activeRoutes)) aria-current="page" @endif><img class="gs-icon" src="{{ asset('icons/'.$icon.'.png') }}" alt="">{{ $label }}</a>
                @endforeach
            </nav>
        </div>
        <div class="gs-sidebar-note"><strong>Your school, connected.</strong>One place for classes and quarterly grades.<div style="margin-top:12px;font-size:10px;letter-spacing:1px">GSYS / {{ strtoupper($portal) }} PORTAL</div></div>
    </aside>
    <div class="gs-body">
        <header class="gs-topbar">
            <div class="gs-topbar-inner">
                <div class="gs-topbar-title"><button type="button" class="gs-mobile-toggle" data-sidebar-open aria-controls="portal-sidebar" aria-expanded="false" aria-label="Open navigation">&#9776;</button><div><strong>@yield('title')</strong><p class="gs-role">GSYS / {{ ucfirst($portal) }} portal</p></div></div>
                <details class="gs-profile">
                    <summary><span class="gs-avatar">{{ mb_strtoupper(mb_substr($displayName,0,1)) }}</span><span class="gs-profile-name">{{ $displayName }}</span><span aria-hidden="true">&rsaquo;</span></summary>
                    <div class="gs-profile-menu"><p class="gs-eyebrow">Signed in as {{ $portal }}</p><strong>{{ $displayName }}</strong><p class="gs-muted gs-small">{{ $identity->username }}</p><a class="gs-btn gs-btn-text" href="{{ route($portal.'.profile') }}">View profile</a><form method="POST" action="{{ route('portal.logout', ['portal' => $portal]) }}">@csrf<button class="gs-btn gs-btn-danger" type="submit">Sign out</button></form></div>
                </details>
            </div>
        </header>
        <main id="portal-content" class="gs-content" tabindex="-1">
            @if(session('success'))<p role="status" class="gs-alert gs-alert-success">{{ session('success') }}</p>@endif
            @if($errors->any())<div role="alert" class="gs-alert gs-alert-error"><strong>Please correct the following:</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('portal-content')
        </main>
    </div>
    @include('portal.partials.scripts')
</div>
@endsection
