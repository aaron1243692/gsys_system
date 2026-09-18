@extends('portal.layout')
@section('title', 'My Subjects')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Teacher','heading'=>'My Subjects','description'=>'Browse your assigned subjects, schedules, and students.'])
<section class="gs-section">
    <div class="gs-section-heading"><div><h2>Subject Teaching Loads</h2><p class="gs-muted gs-small">Each card is one subject assignment for one class and school year.</p></div><span class="gs-badge">{{ $loads->total() }} {{ $loads->total() === 1 ? 'load' : 'loads' }}</span></div>
    <form method="GET" class="gs-actions" style="margin-bottom:18px">
        <label class="gs-field" style="flex:1;max-width:380px">Search subjects or classes<span class="gs-input-wrap"><img src="{{ asset('icons/magnifying-glass.png') }}" alt=""><input name="search" value="{{ $search }}" placeholder="Search subject or class"></span></label>
        <button class="gs-btn gs-btn-primary" style="align-self:end">Search</button>
        @if($search)<a class="gs-btn" style="align-self:end" href="{{ route('teacher.subjects') }}">Reset</a>@endif
    </form>
    <div class="gs-card-grid">
        @forelse($loads as $load)
            <article class="gs-card">
                <div class="gs-card-body">
                    <div class="gs-card-top"><span class="gs-avatar gs-avatar-lg"><img class="gs-icon" src="{{ asset('icons/stack-of-books.png') }}" alt=""></span><div><h3>{{ $load->subject->name }}</h3><p>{{ $load->schoolClass->name }} &middot; SY {{ $load->schoolClass->academicYear?->name ?? 'Not assigned' }}</p></div></div>
                    <dl class="gs-context" style="grid-template-columns:1fr 1fr"><div><dt>Students</dt><dd>{{ $load->studentCount }}</dd></div><div><dt>Schedule</dt><dd>@forelse($load->loadSchedules as $schedule)<span style="display:block">{{ $schedule->day }} &middot; {{ \Carbon\Carbon::parse($schedule->time_from)->format('g:i A') }}–{{ \Carbon\Carbon::parse($schedule->time_to)->format('g:i A') }}{{ $schedule->room ? ' · '.$schedule->room->name : '' }}</span>@empty Not scheduled @endforelse</dd></div></dl>
                </div>
                <div class="gs-card-body" style="padding-top:0"><div class="gs-actions">@foreach([1,2,3] as $quarter) @php($status = $load->gradeSheets->get($quarter)?->status ?? 'NOT STARTED')<span class="gs-badge" data-status="{{ $status }}">Q{{ $quarter }} {{ $status }}</span>@endforeach</div></div>
                <div class="gs-card-foot"><a class="gs-btn" href="{{ route('teacher.subjects.students', $load) }}">View Students</a><a class="gs-btn gs-btn-primary" href="{{ route('teacher.grades', $load) }}">Encode Grades</a></div>
            </article>
        @empty
            <div class="gs-card" style="grid-column:1/-1">@include('portal.partials.empty', ['icon' => 'stack-of-books', 'heading' => $search ? 'No matching subjects' : 'No subjects assigned yet.', 'description' => $search ? 'Try a different subject or class name or reset your search.' : 'Your assigned subject loads will appear here when they are assigned.'])</div>
        @endforelse
    </div>
    @include('portal.partials.pagination', ['paginator' => $loads])
</section>
@endsection
