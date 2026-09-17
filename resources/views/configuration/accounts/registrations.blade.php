@extends('layouts.app')
@section('title', 'Account Registrations')
@section('content')
@include('portal.partials.styles')
<div class="gs-portal" style="padding:24px">
    <div class="gs-page-header"><div><p class="gs-eyebrow">Accounts</p><h1>Account Registrations</h1><p>Review Student and Guardian registrations before portal activation.</p></div></div>
    @if(session('success'))<p class="gs-alert">{{ session('success') }}</p>@endif
    <form method="GET" class="gs-card gs-section"><div class="gs-toolbar"><label class="gs-field">Type<select name="type"><option value="student" @selected($type==='student')>Student</option><option value="guardian" @selected($type==='guardian')>Guardian</option></select></label><label class="gs-field">Status<select name="status">@foreach(['PENDING','ACTIVE','REJECTED','DEACTIVATED'] as $option)<option value="{{ $option }}" @selected($status===$option)>{{ $option }}</option>@endforeach</select></label><label class="gs-field">Registered Date<input type="date" name="date" value="{{ request('date') }}"></label><label class="gs-field gs-search">Search<input type="search" name="search" value="{{ request('search') }}" placeholder="Name, number, email"></label><button class="gs-btn gs-btn-primary">Apply</button></div></form>
    <div class="gs-card"><div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>Name</th><th>Username</th><th>Email</th><th>Student No.</th><th>Registered</th><th>Status</th><th>Action</th></tr></thead><tbody>@forelse($accounts as $account)<tr><td>{{ $type === 'student' ? ($account->info?->name ?? $account->username) : ($account->name ?: $account->username) }}</td><td>{{ $account->username }}</td><td>{{ $account->email }}</td><td>{{ $account->student_number ?? '-' }}</td><td>{{ $account->created_at?->format('M d, Y') }}</td><td><span class="gs-badge" data-status="{{ $account->status }}">{{ $account->status }}</span></td><td><a class="gs-btn" href="{{ route('configuration.accounts.registrations.show', [$type, $account->id]) }}">Review</a></td></tr>@empty<tr><td colspan="7">No registrations found.</td></tr>@endforelse</tbody></table></div></div>
    @include('portal.partials.pagination', ['paginator' => $accounts])
</div>
@endsection
