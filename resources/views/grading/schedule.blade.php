@extends('layouts.app')
@section('title', 'Grade Encoding Schedule')
@section('content')
@include('portal.partials.styles')
<div class="gs-portal" style="padding:24px">
    <div class="gs-page-header"><div><p class="gs-eyebrow">Configuration</p><h1>Grade Encoding Schedule</h1><p>Set a separate encoding period for each quarter and school year.</p></div></div>
    @include('grading.schedule-preview', ['scheduleAdmin' => true])
</div>
@endsection
