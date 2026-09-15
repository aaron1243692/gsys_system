# GSYS web implementation

## Assessment (2026-09-15)

Reuses users, teachers, students, stinfo, guardians, guardianchilds, subject,
subcat, grlvl, acady, class, classsub, curriculum, curriculum_subjects, batch,
track, tracksub, and grades. No departments table exists. class_list is empty;
stinfo is the maintained current enrollment. teachersub/teacherclass are legacy
seeded mappings, with stale references. The maintained authoritative assignment
is subject.teacher_id plus classsub; classsched describes timing, not ownership.

Add account status/review metadata, CHAR(11) student_number, verification fields
to guardianchilds, and grade_sheet_id to grades. New grade_sheets stores aggregate
workflow (pending_grades stores legacy individual four-quarter rows and remains
untouched), grade_encoding_schedules stores windows, audit_events stores actors
and transitions, agreement_records stores versioned acknowledgements.

Preserve separate guards because usernames overlap between account tables.
Check active status every request; grant staff actions through explicit gates.
Reuse portal/admin layouts, logins, class list, entry and reports. Replace preview
registration, schedules, review, profiles and dashboards with persisted workflows.

Existing accounts remain ACTIVE. Existing guardian relationships become PENDING
verification: old rows contain no evidence of staff verification. Existing grades
are preserved and require sheet review; no approval is inferred. No legacy
fourth-quarter column is used. No academic records are deleted. New identifiers
are generated once, independent of school year, and protected from model edits.

Grade range remains the existing configurable 0–100, with at most two decimals
(GRADING_MINIMUM/GRADING_MAXIMUM). This is an encoding range, not a passing policy.
All windows use config('app.timezone'). Returned sheets require a specific future
correction deadline; the normal quarter window does not override that deadline.
