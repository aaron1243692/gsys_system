# Three-quarter grade recording

GSYS records teacher-supplied final grades for Q1, Q2 and Q3. It does not
calculate assessments, averages, GWA, pass/fail, or a year-end grade.

## Identity and assignments

- Teacher: `/portal/teacher/login` → `/teacher/classes`.
- Student: `/portal/student/login` → `/student/grades`.
- Guardian: `/portal/guardian/login` → `/guardian/children`.
- Administrative report: existing `/report/grades` route.

Each portal has a separate session guard backed by the existing account table.
Portal sign-in clears other identities; administrative sign-in clears portal
identities. Portal accounts cannot enter administrative routes. CSRF applies
to web writes, and portal sign-in is throttled.

Assignments come from `classsub` joined to `subject.teacher_id`. Neither
`teacherclass` nor `teachersub` is authoritative in the current application.
Current membership comes from admitted `stinfo` rows with an existing student
account, matching class, academic year and grade level. Inconsistent records
are excluded with a warning; no admission data is silently repaired.

## Grade storage and history

Migration `2026_09_11_000001_extend_grades_for_quarter_recording.php` extends
`grades`. It retains every legacy column/record and makes `class_list_id`
nullable. New records use student/class/subject/year/quarter with a unique
constraint. The existing `class_list` and `pending_grades` tables are untouched.
No fourth-quarter field is read, written or displayed by this workflow.

The inspected local database had zero legacy grades, pending grades and class
list rows. On another installation, legacy records remain intact but are not
automatically converted: they lack trustworthy school-year/teacher provenance.
Review them before any separate backfill. Reports select only new Q1–Q3 rows.

Each row retains class, subject, year, grade-level and student name snapshots,
plus identifiers. Reports never derive historical placement from current
profiles. Catalog/profile edits or deletions cannot cascade-delete these grade
rows. Reused IDs after an external database reset are outside this guarantee.
The original teacher/creator and timestamps are retained; `updated_by` identifies
the most recent teacher editor. A newly assigned teacher can edit current grades;
the previous teacher immediately loses access. Full revision history is not added.

## Rules and bulk entry

`config/grading.php` centralizes the provisional 0–100 range. Set
`GRADING_MINIMUM` and `GRADING_MAXIMUM` in the environment if the institution
adopts another range, then clear configuration cache. Negative grades are always
rejected; storage permits at most 999.99. Up to two decimal places are accepted.
Remarks are optional text (50 characters), never automatically Passed/Failed.

`editable_quarters` is the central extension point for future locking. It
currently permits Q1–Q3; there is no submission or approval stage.

Bulk submissions validate every submitted student before writing. A class row
lock serializes saves; the unique database key is a second duplicate safeguard.
Saving an existing quarter updates it. Blank grades leave existing records
unchanged; an entirely blank submission is rejected. A trailing completion
field detects form truncation by PHP's `max_input_vars`; raise deployment limits
for very large rosters rather than accepting partial submissions. Concurrent
valid edits follow last-save-wins semantics; optimistic edit versions are not
implemented.

## Administrative visibility

`config/grading.php` grants read-only report access to the `admin` role or
existing assignable permission codename `grades.view`. Configure roles there,
or assign that permission through the project's permission mechanism. There
are no administrative grade-writing routes. Filters use historical snapshots.
Quarter filtering displays only the selected quarter's stored values.
Performance reports explicitly remain unimplemented; no rankings are inferred.

## Deployment and verification

Do not run the entire legacy migration chain on a new or populated database.
After inspecting the existing schema, apply only this migration:

```sh
php artisan migrate --path=database/migrations/2026_09_11_000001_extend_grades_for_quarter_recording.php
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

Rollback deliberately refuses to drop grade data; use a reviewed manual plan.
Tests create an isolated in-memory SQLite legacy-schema fixture and apply the
new migration there, without migrating/resetting the configured GSYS database:

```sh
php artisan test
```

The tests cover three-quarter entry, uniqueness, atomic validation, range and
editability rules, unauthorized writes, portal session login/logout, student
and guardian isolation, reassignment, historical context, and report access.

## Local verification (September 11, 2026)

- The targeted migration was applied successfully to the existing MySQL database.
- 22 automated tests passed with 127 assertions.
- MySQL HTTP-kernel checks saved all three quarters and rendered teacher,
  student, linked-guardian, and administrator views. All verification grades
  were enclosed in an outer transaction and rolled back.
- HTTP requests to the existing sign-in page and teacher login returned 200.
- Existing account, admission, class, subject, year and legacy grade records
  were fingerprinted before/after the migration and smoke checks.
- Responsive appearance and keyboard interaction still need a visual browser review.
