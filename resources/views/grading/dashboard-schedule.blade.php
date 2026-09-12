<section class="gs-section"><div class="gs-section-heading"><div><h2>Grade Encoding Status</h2><p class="gs-muted gs-small">Sample schedule / School Year 2026-2027 / {{ config('app.timezone') }}</p></div><span class="gs-badge gs-badge-muted">Frontend preview</span></div><div class="gs-quarter-grid">
@foreach([['Q1','OPEN','Closes Sep 20, 11:59 PM'],['Q2','UPCOMING','Opens Dec 10, 8:00 AM'],['Q3','UPCOMING','Opens Mar 15, 8:00 AM']] as [$q,$status,$date])
<div class="gs-card"><div class="gs-card-body"><div class="gs-section-heading"><h3>{{ $q }}</h3><span class="gs-badge" data-status="{{ $status }}">{{ $status }}</span></div><p class="gs-muted gs-small">{{ $date }}</p></div></div>
@endforeach
</div><p class="gs-footnote">Illustrative states only. Actual encoding deadlines are not connected.</p></section>
