# GSYS full web functional audit

Audit date: 2026-09-18  
Scope: Laravel web application only

## Inventory and execution

- 144 registered routes inspected, including 140 named routes.
- 64 Blade templates and 29 controllers inspected.
- 169 literal Blade `route()` references resolved against Laravel's route collection.
- 110 forms checked for route existence, effective HTTP method, CSRF, and nesting.
- 27 parameter-free staff page endpoints executed through Laravel's HTTP kernel against current data using read-only GET requests: 26 returned 200 and the parameter-dependent subject-map loader returned its expected 302 redirect. No 4xx or 5xx response occurred.
- State-changing requests were exercised in isolated SQLite test databases. The current GSYS database was not modified.

## Findings and repairs

1. The legacy `/teacher/classes` redirect accepted every HTTP verb because `Route::redirect` registers an `ANY` route. It now accepts only GET/HEAD and has the explicit name `teacher.classes.legacy`. POST and DELETE return 405 as intended for a read-only URL.
2. The previously repaired grade action mismatch remains covered: both current teaching-load URLs and stale class/subject grade forms accept the correct POST request, with authorization and CSRF intact.
3. Teacher load ownership consistently uses `classsub.teacher_id`; adviser access consistently uses `class.adviser_id` and does not grant grading rights.
4. Student portal identity resolves through `student_accounts.student_id` to the academic `students` record. Guardian access requires a verified `guardianchilds` relationship.
5. Grade Entry resolves school year from the assigned class and matches the encoding schedule by that exact year and quarter.

## Action matrix

| Role | Page | Action | Method | Result | Fix |
|---|---|---|---|---|---|
| Public | Staff/portal login | Authenticate and reject invalid credentials | POST | PASS | — |
| Public | Student/guardian registration | Register and validate identity claims | POST | PASS | — |
| Admin | Dashboard and navigation | Open visible staff destinations | GET | PASS | — |
| Admin | Curriculum configuration | List/search and render Add/Edit/Delete forms | GET + POST/PUT/DELETE | PASS | — |
| Admin | Grade encoding schedule | Open page, validate year/quarter/window, save | GET + POST | PASS | — |
| Admin | Class Schedule | List, create/update class meetings, delete | GET + POST/PUT/DELETE | PASS | — |
| Admin | Teacher Load | Assign, reassign, remove and reflect immediately in portal | GET + POST/PUT/DELETE | PASS | Uses `classsub` consistently |
| Admin | Rooms | List and CRUD form contracts | GET + POST/PUT/DELETE | PASS | — |
| Admin | Students | Search, placement forms, link status and account link | GET + PUT/POST | PASS | Explicit academic/account IDs |
| Admin | Account registrations | Review, link, activate/reject | GET + POST | PASS | Link required before student activation |
| Admin | Student/guardian/teacher accounts | List and CRUD/reset form contracts | GET + POST/PUT/DELETE | PASS | — |
| Admin | Users and roles | List, CRUD, reset and permission form contracts | GET + POST/PUT/DELETE | PASS | — |
| Staff | Grade Approval | Filter, review, approve | GET + POST | PASS | Full request/database workflow tested |
| Staff | Grade Approval | Return with reason/deadline validation | POST | PASS | Validation and state checks retained |
| Teacher | Dashboard | Scoped load/student/schedule/advisory counts | GET | PASS | Shared teaching-load query |
| Teacher | My Subjects | Search, pagination, View Students, Encode Grades | GET | PASS | Stable teaching-load ID |
| Teacher | Advisory Class | View only assigned advisory roster | GET | PASS | Adviser relationship separated |
| Teacher | Grade Entry | Quarter selection and student search UI | GET | PASS | Exact load/year roster |
| Teacher | Grade Entry | Save Draft | POST | PASS | DRAFT values persist after refresh |
| Teacher | Grade Entry | Submit | POST | PASS | Becomes SUBMITTED |
| Teacher | Legacy Grade Entry | Save/submit stale class/subject form | POST | PASS | Compatibility POST resolves owned load |
| Teacher | Legacy My Classes | Redirect | GET | FIXED | Restricted from ANY to GET/HEAD |
| Teacher | Grade History | Open scoped sheets and preserve filters | GET | PASS | Teacher-scoped query |
| Teacher | Profile | View, validation and save | GET + POST | PASS | Guard-scoped identity |
| Student | Dashboard/Subjects | Resolve linked academic enrollment | GET | PASS | Account-to-academic link |
| Student | Grades | View only own APPROVED grades | GET | PASS | Draft/submitted/returned excluded |
| Student | Profile | View, validation and save | GET + POST | PASS | Guard-scoped identity |
| Guardian | Dashboard/Children | View verified children and subjects | GET | PASS | Verified relationship required |
| Guardian | Child Grades | View approved grades; forged child denied | GET | PASS | Server-side relationship check |
| Guardian | Child Link | Submit identity claim and reject duplicates | POST | PASS | Explicit verification workflow |
| Guardian | Profile | View, validation and save | GET + POST | PASS | Guard-scoped identity |
| All | Search/filter/pagination | Preserve query strings | GET | PASS | Paginators use `withQueryString()` |
| All | Modal actions | Open/close IDs and action form targets | UI + form methods | PASS (structural) | No duplicate static action target found |

## Connected academic scenario

The automated scenario creates one class, one subject teaching load, Jaycee-equivalent teacher ownership, three enrolled students, an open Q1 window, linked student accounts, and a verified guardian. It verifies:

1. Teacher sees the same load and all three students.
2. Grades 90, 91, and 89 save as DRAFT and survive refresh.
3. Submit changes the sheet to SUBMITTED.
4. Staff sees and approves the same sheet through the approval controller.
5. The sheet changes to APPROVED.
6. The first student sees only grade 90.
7. The verified guardian sees the same grade 90.
8. The second student sees only grade 91 and cannot see the first student's grade.

## Result counts

| Measure | Result |
|---|---:|
| Page endpoints request-tested | 27 staff pages plus public and portal pages covered by feature tests |
| Form/action contracts audited | 110 |
| Named route references audited | 169 |
| 405 defects found | 1 additional legacy redirect issue; fixed |
| 422 defects found | 0 unexplained; observed 422 responses are validation cases |
| Authorization defects found | 0 additional |
| Broken-link/404 defects found | 0 |
| 500 errors found | 0 |
| Broken forms found | 0 additional |
| Wrong route parameters found | 0 additional |
| Incorrect account/academic IDs found | 0 additional |
| Relationship mismatches found | 0 additional after earlier `classsub` and student-link repairs |

## Verification boundary

Request-level tests verify server behavior, database effects, redirects, validation, and rendered responses. Modal animation and browser-native dialog focus behavior were inspected structurally because the repository has no browser automation dependency. No known visible GSYS-generated form or link produces an unexplained 405, 422, or 500 response.
