# GSYS action, link, and route audit

Audit date: 2026-09-18

## Exact reported URL

`GET /teacher/subjects/8/12/grades` previously matched `teacher.grades` with:

- `schoolClass = 8`: Grade 12 STEM A, academic year ID 6 (2025-2026)
- `subject = 12`: Empowerment Technologies
- authenticated teacher and `teachers.id = 1`: jaycee (`username = teacher`)
- authoritative teaching load: `classsub.id = 41`

The live Laravel log contains no 422 exception for this GET. Before the route redesign, the controller and Blade rendered the URL successfully with HTTP 200. The only grade-related 422 conditions found in code apply to POST submission: an incomplete sheet, or a class missing academic-year/grade-level configuration. Therefore the original 422 cannot be attributed to a surviving logged exception.

The route design was still fragile: buttons independently passed a class ID and subject ID even though the displayed record was a `classsub` teaching load. All current teacher grade buttons now pass that load's stable ID.

## Route correction

| Action | Old route | Current route | Result |
|---|---|---|---|
| Encode/Open Grade Sheet | `/teacher/subjects/{schoolClass}/{subject}/grades` | `/teacher/subjects/{classSubject}/grades` | Exact displayed load controls subject, class, year, roster, and authorization. |
| Save Draft / Submit | POST with class + subject | POST `/teacher/subjects/{classSubject}/grades` | Uses the same load ID as the page. |
| Old bookmarked grade URL | class + subject route | compatibility GET resolves the authenticated teacher's matching load and redirects | Working old links are preserved without weakening authorization. |
| Stale open Grade Entry form | POST class + subject route | compatibility POST resolves the authenticated teacher's matching load and runs the same store action | A page opened before the load-ID route change can still save or submit without HTTP 405. |
| View Students | `/teacher/subjects/{classSubject}/students` | unchanged | Already used the stable load ID. |

Another teacher's existing load returns 403. A missing load ID returns 404. Missing or closed encoding configuration renders Grade Entry read-only on GET and the server rejects a grade POST.

## Static route audit

- 144 routes inspected, including 140 named routes.
- 169 literal Blade `route()` references inspected.
- Zero references to missing named routes.
- 101 forms with literal named-route actions inspected for GET/POST/PUT/PATCH/DELETE agreement.
- No confirmed route-method mismatch.
- No placeholder `href="#"`, `action="#"`, or `javascript:` navigation found.
- Modal `onclick` actions reference page-local dialog IDs and do not construct academic URLs.

## Action audit results

| Role | Page | Action | Before | After | Result |
|---|---|---|---|---|---|
| Teacher | My Subjects | Encode Grades | Loose class ID + subject ID; reported 422 | Stable load ID 41; HTTP 200 | FIXED |
| Teacher | My Subjects | View Students | Load ID | Load ID; HTTP 200 for own load | PASS |
| Teacher | Grades | Open Grade Sheet | Loose class + subject | Stable load ID | FIXED |
| Teacher | Grade Entry | Quarter selection | Integer 1/2/3 | Integer 1/2/3; own load retained | PASS |
| Teacher | Grade Entry | Save Draft | Class + subject URL | Same load ID as page; OPEN+DRAFT persists | FIXED/PASS |
| Teacher | Grade Entry | Submit | Class + subject URL | Same load ID; complete sheet becomes SUBMITTED and locks | FIXED/PASS |
| Teacher | Grade Entry | Direct foreign load | Relationship check | Shared load ownership check returns 403 | PASS |
| Teacher | Old bookmark | Open `/8/12/grades` | Reported 422 | Redirects to `/teacher/subjects/41/grades` | FIXED |
| Teacher | Stale Grade Entry page | POST `/8/12/grades` | Legacy route accepted GET only, causing 405 | Compatibility POST saves and submits through load 41 | FIXED/PASS |
| Teacher | Dashboard/My Subjects/Grades | Load counts/list | Separate queries previously possible | Shared `TeacherTeachingLoads` query | PASS |
| Teacher | Advisory Class | View students | Explicit adviser relation | Explicit adviser relation; no grade authority | PASS |
| Teacher | Grade History | View rows | Teacher-scoped sheets | Teacher-scoped sheets with subject/class/year | PASS |
| Teacher | Profile | Save | Guard-scoped authenticated record | Password verified and unique email validated | PASS |
| Student | Dashboard | View own data | Linked account chain | Linked account -> academic student only | PASS |
| Student | Subjects | View | Enrollment class/year chain | Same chain; subject teacher and schedule | PASS |
| Student | Grades | View | Student-scoped approved grades | Own student only; forged student ID returns 403 | PASS |
| Student | Profile | Save | Guard-scoped account | Current-password and account validation | PASS |
| Guardian | My Children | View child | Verified link required | Verified `guardianchilds` required | PASS |
| Guardian | Child Grades | View | Verified link authorization | Unlinked/revoked child returns 403 | PASS |
| Guardian | Request Link | Submit | Student number + identity checks | Duplicate/invalid claims rejected | PASS |
| Guardian | Profile | Save | Guard-scoped account | Current-password and account validation | PASS |
| Admin | Teacher Load | Assign/Reassign/Remove | `classsub.teacher_id` | Same record used immediately by portal | PASS |
| Admin | Encoding Schedule | Save | Year + integer quarter | Same year/quarter used by Grade Entry | PASS |
| Admin | Grade Approval | Review/Approve/Return | Grade-sheet ID | Grade-sheet workflow and audit event | PASS |
| Admin | Student Account | Activate/Link/View | Explicit account and student IDs | One-to-one link validation | PASS |
| Admin | Guardian Account | Verify/Activate | Explicit guardian-child link | Verified child required for activation/access | PASS |
| Admin | Configuration CRUD | Add/Edit/Delete dialogs and forms | Named controller routes | Route names and HTTP verbs match | PASS |
| Admin | Class Schedule | Add/Edit/Delete meeting | Named class/schedule routes | Route names, bindings, and verbs match | PASS |
| All roles | Navigation/search/pagination/back links | GET | Named routes and query strings | No missing route references found | PASS |

## Verification boundary

Write actions were exercised with the isolated in-memory test database. Live production-style data was used read-only to request Jaycee's own grade and student pages through Laravel's HTTP kernel. No live record was created, edited, approved, submitted, removed, or reassigned during this audit.
