@extends('portal.layout')
@section('title', 'My Children')
@section('portal-content')
@include('portal.partials.page-header', ['section'=>'Guardian','heading'=>'My Children','description'=>'Authorized linked children associated with your account.'])
<section class="gs-section">
    <div class="gs-section-heading"><div><h2>My Children</h2><p class="gs-muted gs-small">Select a child to view their quarterly grades.</p></div><div class="gs-actions"><span class="gs-badge">{{ $children->total() }} linked</span><button type="button" class="gs-btn gs-btn-primary" data-open-dialog="add-child-dialog">Add Child</button></div></div>
    <div class="gs-card-grid">
        @forelse($children as $child)
            @php($childName = $child->info?->name ?? $child->username)
            <article class="gs-card"><div class="gs-card-body"><div class="gs-card-top"><span class="gs-avatar gs-avatar-lg">{{ mb_strtoupper(mb_substr($childName,0,1)) }}</span><div><h3>{{ $childName }}</h3><p>Student ID: {{ $child->id }}</p></div></div><dl class="gs-context" style="grid-template-columns:1fr 1fr"><div><dt>Grade Level / Section</dt><dd>View in grade records</dd></div><div><dt>School Year</dt><dd>View in grade records</dd></div></dl></div><div class="gs-card-foot"><span class="gs-badge gs-badge-muted">Linked student</span><a class="gs-btn gs-btn-primary" href="{{ route('guardian.grades', $child) }}">View Grades <span aria-hidden="true">&rsaquo;</span></a></div></article>
        @empty
            <div class="gs-card" style="grid-column:1/-1">@include('portal.partials.empty', ['icon' => 'children', 'heading' => 'No students are linked to your account.', 'description' => 'Contact your school to connect your child. Their records will appear here once linked.'])</div>
        @endforelse
    </div>
    @include('portal.partials.pagination', ['paginator' => $children])
</section>
<dialog id="add-child-dialog" class="gs-dialog" aria-labelledby="add-child-title"><div class="gs-dialog-head"><div><p class="gs-eyebrow">My Children</p><h2 id="add-child-title">Add Child</h2></div><button type="button" class="gs-close" data-close-dialog aria-label="Close add child">&times;</button></div><form class="gs-card-body" onsubmit="event.preventDefault(); this.querySelector('[data-add-child-status]').hidden = false;"><p class="gs-alert gs-alert-warning">Frontend preview only. This does not find a student, create a link, or grant access to grades.</p><label class="gs-field">Student Number<input required autocomplete="off" placeholder="Enter student number"></label><label class="gs-field" style="margin-top:14px">Relationship<select required><option value="">Select relationship</option><option>Parent</option><option>Legal Guardian</option><option>Other authorized guardian</option></select></label><p class="gs-footnote">The school must verify your identity and relationship. A student number alone is never sufficient authorization.</p><p class="gs-alert" data-add-child-status hidden role="status">Verification request previewed. No information was submitted.</p><div class="gs-actions" style="justify-content:flex-end"><button type="button" class="gs-btn" data-close-dialog>Cancel</button><button class="gs-btn gs-btn-primary">Request Verification</button></div></form></dialog>
@endsection
