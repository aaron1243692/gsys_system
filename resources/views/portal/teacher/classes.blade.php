@extends('portal.layout')
@section('title', 'My Classes')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Teacher','heading'=>'My Classes','description'=>'Browse assigned class and subject combinations.'])
<section class="gs-section">
    <div class="gs-section-heading"><div><h2>My Classes</h2><p class="gs-muted gs-small">Choose a subject to open its grade sheet.</p></div><span class="gs-badge">{{ $classes->total() }} {{ $classes->total() === 1 ? 'class' : 'classes' }}</span></div>
    <form method="GET" class="gs-actions" style="margin-bottom:18px">
        <label class="gs-field" style="flex:1;max-width:380px">Search classes<span class="gs-input-wrap"><img src="{{ asset('icons/magnifying-glass.png') }}" alt=""><input name="search" value="{{ $search }}" placeholder="Search class name"></span></label>
        <button class="gs-btn gs-btn-primary" style="align-self:end">Search</button>
        @if($search)<a class="gs-btn" style="align-self:end" href="{{ route('teacher.classes') }}">Reset</a>@endif
    </form>
    <div class="gs-card-grid">
        @forelse($classes as $class)
            <article class="gs-card">
                <div class="gs-card-body"><div class="gs-card-top"><span class="gs-avatar gs-avatar-lg"><img class="gs-icon" src="{{ asset('icons/higher-education.png') }}" alt=""></span><div><h3>{{ $class->name }}</h3><p>School Year {{ $class->academicYear?->name ?? 'Not assigned' }}</p></div></div>
                    @foreach($class->classSubjects->unique('sub_id') as $assignment)
                        @if($assignment->subject && (int) $assignment->subject->teacher_id === (int) auth('teacher')->id())
                            <div class="gs-subject-row"><div><strong>{{ $assignment->subject->name }}</strong><small>Quarterly grade sheet</small></div><a class="gs-btn gs-btn-primary" aria-label="Encode grades for {{ $assignment->subject->name }} in {{ $class->name }}" href="{{ route('teacher.grades', [$class, $assignment->subject]) }}">Encode Grades</a></div>
                        @endif
                    @endforeach
                </div>
                <div class="gs-card-foot"><span class="gs-muted gs-small">Student list available inside</span><span class="gs-badge gs-badge-muted">Q1 / Q2 / Q3</span></div>
            </article>
        @empty
            <div class="gs-card" style="grid-column:1/-1">@include('portal.partials.empty', ['icon' => 'stack-of-books', 'heading' => $search ? 'No matching classes' : 'No classes assigned yet.', 'description' => $search ? 'Try a different class name or reset your search.' : 'Your assigned classes and subjects will appear here when they are available.'])</div>
        @endforelse
    </div>
    @include('portal.partials.pagination', ['paginator' => $classes])
</section>
@endsection
