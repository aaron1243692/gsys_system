# Grading workflow frontend handoff

This implementation represents the workflow in the existing Blade application. It does not implement persistence, approval authorization, or schedule enforcement.

## Interfaces

- Admin: existing Configuration > Grade Encoding Schedule, with separate sample school years and Q1–Q3 dates, automatic preview statuses, and date/time editing.
- Teacher: existing dashboard and class cards, sample schedule summary, four-column manual final-grade entry, missing-grade indicators, Save Draft and Submit Grade Sheet demonstrations, submission confirmation, and Draft/Submitted/Returned/Approved appearances. Returned sheets demonstrate correction access even when the sample period is closed; existing disabled access is not enabled.
- Staff/Admin: existing Reports > Approval page now contains a sample queue, summary cards, six filters and search, read-only whole-sheet review, approval confirmation, and required return reason. Existing real class-subject assignments remain accessible below the demonstration.
- Student/Guardian: shared approved-grade presentation, Q1–Q3 only. Values without explicit approval metadata appear as Not yet available, including subject-detail dialogs. Existing identity and child navigation remain. Guardian grade context uses supplied record information.

## Files

Created:
- resources/views/grading/teacher-workflow.blade.php
- resources/views/grading/dashboard-schedule.blade.php
- public/js/grade-sheet-workflow.js
- public/js/grade-approval.js

Updated:
- resources/views/report/grades/aproval.blade.php (existing route/view retained)
- resources/views/portal/teacher/entry.blade.php
- resources/views/portal/teacher/classes.blade.php
- resources/views/portal/grades.blade.php
- resources/views/portal/guardian/children.blade.php
- resources/views/portal/partials/grade-table.blade.php
- resources/views/portal/partials/styles.blade.php
- resources/views/portal/layout.blade.php (navigation glyph cleanup)
- resources/views/grading/schedule-preview.blade.php (column labels)

Reused: Admin layout/header, scoped portal styles, portal layout/navigation, stat cards, pagination, empty states, dialog controls, student search, manual-table scrolling, and existing schedule preview/editor.

## Demonstration boundaries

- Frontend changes are in memory only and reset on reload; they do not transfer between accounts or pages.
- Teacher draft/submit buttons are type=button. The demonstration form suppresses submission, including Enter. Existing grade-saving controller/routes remain unchanged but are not invoked by the new workflow controls.
- Approval uses explicitly named sample students and teachers. Approve/Return do not issue requests.
- All dates in appearance demonstrations are labeled samples. Admin schedule status calculation uses the configured timezone and server time supplied at page load.
- Student/guardian rendering anticipates q1_status/q2_status/q3_status with APPROVED values. The existing report does not yet supply those fields, so current values are unavailable in the new presentation. This is a view-level representation, not secure server-side publication filtering.
- No file import or grade calculation exists in this frontend workflow.

## Responsive and accessibility

Scoped Admin-style colors, badges, cards and dialogs; wrapping filter/action toolbars; horizontally scrolling tables; sticky manual-entry header; numeric keyboard support and sequential grade-field tabbing; read-only/disabled states; status messages; named dialogs and controls; focus restoration from review to filters. Existing mobile sidebar is reused.

## Verification

- Blade compilation passed.
- Read-only HTTP rendering passed for Admin schedule, Approval, Teacher classes/entry, Student grades, Guardian children/grades; rendered element IDs were unique.
- All 12 combinations of grade-sheet and encoding state checked, plus three approval filtering cases.
- Render fixture verified approved values appear and submitted/returned/draft values and private remarks do not.
- Hash comparison confirmed app, bootstrap, config, routes, and database files unchanged during this task.
- No migrations or data writes were run. Browser visual and full interaction testing remain outstanding.

## Backend work still required

1. Persist schedules per school year and quarter; validate dates with the application timezone.
2. Persist grade sheets and drafts, submission transitions, audit history, and return reasons.
3. Enforce assignment, schedule windows, state locks, and controlled returned-sheet correction access on every write.
4. Authorize reviewers and approve/return entire sheets atomically.
5. Publish only approved grades from student/guardian queries, enforcing ownership and guardian linkage server-side; supply an agreed approval metadata contract to views.
6. Define missing-grade submission rules, correction deadlines, concurrent-edit handling, and notifications.
7. Connect frontend controls to tested endpoints and remove appearance selectors/sample data for production.
