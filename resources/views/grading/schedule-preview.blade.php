<div data-schedule-preview data-server-now="{{ now()->getTimestampMs() }}" data-timezone="{{ config('app.timezone') }}">
    <p class="gs-alert">Schedule UI preview. Sample school years and dates only. Changes last until this page is reloaded; they do not control actual grade saving.</p>
    <div class="gs-section-heading"><label class="gs-field">School Year (sample)<select data-schedule-year><option>2026-2027</option><option>2027-2028</option></select></label><p class="gs-muted gs-small">All times: {{ config('app.timezone') }}<br>Status follows server time supplied when this page loaded.</p></div>
    @if($scheduleAdmin)
    <div class="gs-card gs-section"><div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>Quarter</th><th>Encoding Starts</th><th>Encoding Ends</th><th>Status</th><th>Action</th></tr></thead><tbody data-schedule-rows></tbody></table></div></div>
    <dialog class="gs-dialog" data-schedule-editor aria-label="Edit quarter schedule">
        <div class="gs-dialog-head"><h2 data-schedule-title></h2><button type="button" class="gs-close" data-schedule-cancel aria-label="Close schedule editor">&times;</button></div>
        <form class="gs-card-body" data-schedule-form>
            <p class="gs-muted gs-small" data-edit-year></p>
            <div class="gs-card-grid" style="margin:18px 0">
                <label class="gs-field">Opening Date<input type="date" name="openDate" required></label>
                <label class="gs-field">Opening Time<input type="time" name="openTime" required></label>
                <label class="gs-field">Closing Date<input type="date" name="closeDate" required></label>
                <label class="gs-field">Closing Time<input type="time" name="closeTime" required></label>
            </div>
            <p class="gs-error" data-schedule-error role="alert"></p>
            <div class="gs-actions" style="justify-content:flex-end"><button type="button" class="gs-btn" data-schedule-cancel>Cancel</button><button class="gs-btn gs-btn-primary">Save Schedule</button></div>
        </form>
    </dialog>
    <p data-schedule-feedback role="status" class="gs-muted gs-small"></p>
    @endif
    <section class="gs-section">
        <div class="gs-section-heading"><div><h2>Teacher appearance preview</h2><p class="gs-muted gs-small">Use the sample schedule or inspect each state. Preview grades are never submitted.</p></div></div>
        <div class="gs-actions" style="margin-bottom:16px"><label class="gs-field">Quarter<select data-preview-quarter><option value="1">Quarter 1</option><option value="2">Quarter 2</option><option value="3">Quarter 3</option></select></label><label class="gs-field">Preview mode<select data-preview-state><option value="auto">Follow sample schedule</option><option value="OPEN">Open appearance</option><option value="UPCOMING">Upcoming appearance</option><option value="CLOSED">Closed appearance</option></select></label></div>
        <div class="gs-card"><div class="gs-card-body"><p class="gs-eyebrow">Sample class / Mathematics</p><h3>Grade Encoding: <span class="gs-badge" data-preview-badge></span></h3><p style="margin-top:12px" data-preview-message></p><p class="gs-muted gs-small" data-preview-dates></p></div>
            <div class="gs-table-wrap"><table class="gs-table"><thead><tr><th>Student (sample)</th><th>Final Grade</th></tr></thead><tbody><tr><td>Sample Student A</td><td><input class="gs-grade-input" data-preview-grade aria-label="Sample Student A final grade" type="number" inputmode="decimal" min="0" max="100" step="0.01" value="88" disabled></td></tr><tr><td>Sample Student B</td><td><input class="gs-grade-input" data-preview-grade aria-label="Sample Student B final grade" type="number" inputmode="decimal" min="0" max="100" step="0.01" disabled></td></tr></tbody></table></div>
            <div class="gs-savebar"><p class="gs-muted gs-small">Appearance preview only</p><button type="button" class="gs-btn gs-btn-primary" data-preview-save disabled>Save Grades</button></div>
            <p class="gs-card-body gs-muted gs-small" data-preview-feedback role="status"></p>
        </div>
    </section>
</div>
<script src="{{ asset('js/grade-schedule-preview.js') }}" defer></script>
