@extends('layouts.clean')
@section('title', 'Registration Submitted')
@section('clean')
@include('portal.partials.public-styles')
<main class="gs-public">
    <div class="gs-public-shell">
        <header class="gs-public-head"><div><p>Cauayan City National High School</p><h1>Registration Submitted</h1></div><a href="{{ route('portal.login', ['portal' => $portal]) }}">Sign In</a></header>
        <div class="gs-public-body">
            <section class="gs-panel gs-success">
                <h2>Registration Submitted</h2>
                @if($portal === 'student')
                    <p>Your account is pending staff review and activation.</p>
                    @if($registration['number'] ?? null)
                        <p>Student Number: <strong>{{ $registration['number'] }}</strong></p>
                    @endif
                @else
                    <p>Your guardian account is pending staff review and activation. Children are linked separately by authorized school staff.</p>
                @endif
                <p class="gs-notice"><strong>Status: Pending Approval</strong><br>Pending accounts cannot sign in until school staff activates them.</p>
                <a class="gs-btn gs-btn-primary" href="{{ route('portal.login', ['portal' => $portal]) }}">Back to Login</a>
            </section>
        </div>
    </div>
</main>
@endsection
