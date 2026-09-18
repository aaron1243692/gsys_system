@extends('portal.layout')
@section('title', 'My Children')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Guardian','heading'=>'My Children','description'=>'Children linked by authorized school staff.'])
@if(session('success'))<p class="gs-alert">{{ session('success') }}</p>@endif
@if($errors->any())<p class="gs-error">{{ $errors->first() }}</p>@endif
<section class="gs-section">
    <div class="gs-section-heading"><div><h2>My Children</h2><p class="gs-muted gs-small">Select a child to view approved grades.</p></div><span class="gs-badge">{{ $children->total() }} {{ $children->total() === 1 ? 'child' : 'children' }}</span></div>
    <div class="gs-card-grid">
        @forelse($children as $child)
            @php($childName = $child->info?->name ?? $child->username)
            @php($childClass = $child->info?->admited && $child->info?->schoolClass?->acady_id === $child->info?->acady_id && $child->info?->schoolClass?->grlvl_id === $child->info?->grlvl_id ? $child->info->schoolClass : null)
            <article class="gs-card"><div class="gs-card-body"><div class="gs-card-top"><span class="gs-avatar gs-avatar-lg">{{ mb_strtoupper(mb_substr($childName,0,1)) }}</span><div><h3>{{ $childName }}</h3><p>Student Number: {{ $child->student_number }}</p></div></div><dl class="gs-context" style="grid-template-columns:1fr 1fr"><div><dt>Grade Level / Section</dt><dd>{{ $child->info?->gradeLevel?->name ?? '-' }} / {{ $childClass?->name ?? '-' }}</dd></div><div><dt>School Year</dt><dd>{{ $child->info?->academicYear?->name ?? '-' }}</dd></div><div><dt>Class Adviser</dt><dd>{{ $childClass?->adviser?->name ?? 'Not assigned' }}</dd></div><div><dt>Relationship</dt><dd>{{ $child->guardianRelationship ?? '-' }}</dd></div></dl><p class="gs-muted gs-small">@foreach($childClass?->classSubjects ?? [] as $load)@if($load->subject){{ $load->subject->name }} · {{ $load->teacher?->name ?? 'Not assigned' }}; @foreach($childClass->classSchedules->where('subject_id', $load->sub_id) as $schedule){{ $schedule->day }} {{ $schedule->room?->name }} @endforeach @endif @endforeach</p></div><div class="gs-card-foot"><a class="gs-btn gs-btn-primary" href="{{ route('guardian.grades', $child) }}">View Academic Record</a></div></article>
        @empty
            <div class="gs-card" style="grid-column:1/-1">@include('portal.partials.empty', ['icon' => 'children', 'heading' => 'No children linked yet.', 'description' => 'Contact authorized school staff if a child should be linked to your account.'])</div>
        @endforelse
    </div>
    @include('portal.partials.pagination', ['paginator' => $children])
</section>
@endsection
