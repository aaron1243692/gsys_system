<div class="gs-card">
    <form method="GET" class="gs-toolbar">
        <label class="gs-field">School Year<select name="academic_year_id"><option value="">All school years</option>@foreach($options['academic_year'] as $year)<option value="{{ $year->academic_year_id }}" @selected((string)($filters['academic_year_id'] ?? '') === (string)$year->academic_year_id)>{{ $year->academic_year_name }}</option>@endforeach</select></label>
        <button class="gs-btn gs-btn-primary">Apply</button><a class="gs-btn" href="{{ url()->current() }}">Reset</a>
        <span class="gs-muted gs-small" style="margin-left:auto;align-self:center">{{ $grades->total() }} subject record(s)</span>
    </form>
    <div class="gs-table-wrap" tabindex="0" role="region" aria-label="Quarterly grades">
        <table class="gs-table"><thead><tr><th scope="col">Subject</th><th scope="col">Class / School Year</th>@foreach([1,2,3] as $q)<th scope="col">Q{{ $q }}</th>@endforeach</tr></thead><tbody>
            @forelse($grades as $i => $record)
                <tr><td><strong>{{ $record->subject_name }}</strong></td><td><strong>{{ $record->class_name }}</strong><small>{{ $record->grade_level_name }} / {{ $record->academic_year_name }}</small></td>@foreach([1,2,3] as $q)<td>@if(($record->{'q'.$q.'_status'} ?? null) === 'APPROVED' && $record->{'q'.$q} !== null)<span class="gs-grade-value">{{ $record->{'q'.$q} }}</span><small>{{ $record->{'remarks'.$q} }}</small>@else<span class="gs-badge gs-badge-muted">Not yet available</span>@endif</td>@endforeach</tr>
            @empty
                <tr><td colspan="5">@include('portal.partials.empty', ['icon' => 'book', 'heading' => 'No approved grades available.', 'description' => 'Approved quarter grades will appear here when available. Try another school year or check back later.'])</td></tr>
            @endforelse
        </tbody></table>
    </div>
</div>
@include('portal.partials.pagination', ['paginator' => $grades])
