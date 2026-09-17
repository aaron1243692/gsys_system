@extends('portal.layout')
@section('title', 'My Children')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Guardian','heading'=>'My Children','description'=>'Verified and pending child relationships for your account.'])
@if(session('success'))<p class="gs-alert">{{ session('success') }}</p>@endif
@if($errors->any())<p class="gs-error">{{ $errors->first() }}</p>@endif
<section class="gs-section">
    <div class="gs-section-heading"><div><h2>Verified Children</h2><p class="gs-muted gs-small">Select a child to view approved grades.</p></div><span class="gs-badge">{{ $children->total() }} linked</span></div>
    <div class="gs-card-grid">
        @forelse($children as $child)
            @php($childName = $child->info?->name ?? $child->username)
            <article class="gs-card"><div class="gs-card-body"><div class="gs-card-top"><span class="gs-avatar gs-avatar-lg">{{ mb_strtoupper(mb_substr($childName,0,1)) }}</span><div><h3>{{ $childName }}</h3><p>Student Number: {{ $child->student_number }}</p></div></div><dl class="gs-context" style="grid-template-columns:1fr 1fr"><div><dt>Grade Level / Section</dt><dd>{{ $child->info?->gradeLevel?->name ?? '-' }} / {{ $child->info?->schoolClass?->name ?? '-' }}</dd></div><div><dt>School Year</dt><dd>{{ $child->info?->academicYear?->name ?? '-' }}</dd></div></dl></div><div class="gs-card-foot"><span class="gs-badge gs-badge-muted">Verified</span><a class="gs-btn gs-btn-primary" href="{{ route('guardian.grades', $child) }}">View Grades</a></div></article>
        @empty
            <div class="gs-card" style="grid-column:1/-1">@include('portal.partials.empty', ['icon' => 'children', 'heading' => 'No verified children yet.', 'description' => 'Submit a claim below or contact your school for verification.'])</div>
        @endforelse
    </div>
    @include('portal.partials.pagination', ['paginator' => $children])
</section>
<section class="gs-section"><div class="gs-section-heading"><h2>Request Child Link</h2></div><form method="POST" action="{{ route('guardian.children.link') }}" class="gs-card gs-card-body">@csrf<div class="gs-grid"><label class="gs-field">Student Number<input name="student_number" required maxlength="11" inputmode="numeric"></label><label class="gs-field">Student Name<input name="student_name" required></label><label class="gs-field">Student Birthdate<input type="date" name="student_birthdate" required></label><label class="gs-field">Relationship<input name="relationship" required></label></div><div class="gs-actions"><button class="gs-btn gs-btn-primary">Request Verification</button></div></form></section>
<section class="gs-section"><div class="gs-section-heading"><h2>Pending or Rejected Requests</h2></div><div class="gs-card"><div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>Student</th><th>Relationship</th><th>Status</th><th>Note</th></tr></thead><tbody>@forelse($requests as $request)<tr><td>{{ $request->claimed_student_name }}</td><td>{{ $request->relationship }}</td><td><span class="gs-badge" data-status="{{ $request->status }}">{{ $request->status }}</span></td><td>{{ $request->verification_note ?? '-' }}</td></tr>@empty<tr><td colspan="4">No pending requests.</td></tr>@endforelse</tbody></table></div></div></section>
@endsection
