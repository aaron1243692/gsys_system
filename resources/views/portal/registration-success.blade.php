@extends('layouts.clean')
@section('title', 'Registration Submitted')
@section('clean')
@include('portal.partials.public-styles')
<main class="gs-public">
    <div class="gs-public-shell">
        <header class="gs-public-head"><div><p>Cauayan City National High School</p><h1>Registration Submitted</h1></div><a href="{{ route('portal.login', ['portal' => $portal]) }}">Sign In</a></header>
        <div class="gs-public-body">
            <section class="gs-panel gs-success">
                <h2>Pending staff review</h2>
                @if($portal === 'student')
                    <p>Your account is pending staff review and linking to your academic student record. Your official Student Number will appear after linking.</p>
                @else
                    <p>Your guardian account and child claim were submitted. Staff must verify the relationship before activation.</p>
                @endif
                <p class="gs-notice">Pending accounts cannot sign in until school staff activates them.</p>
                <a class="gs-btn gs-btn-primary" href="{{ route('portal.login', ['portal' => $portal]) }}">Return to Sign In</a>
            </section>
        </div>
    </div>
</main>
@endsection
