<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{
    public function grades(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $grades = DB::table('stinfo as students')
            ->leftJoin('class as classes', 'students.class_id', '=', 'classes.id')
            ->leftJoin('grlvl as grade_levels', 'students.grlvl_id', '=', 'grade_levels.id')
            ->leftJoin('acady as academic_years', 'students.acady_id', '=', 'academic_years.id')
            ->leftJoin('classsub as class_subjects', 'classes.id', '=', 'class_subjects.class_id')
            ->leftJoin('subject as subjects', function ($join) {
                $join->on('class_subjects.sub_id', '=', 'subjects.id')
                    ->whereNull('subjects.deleted_at');
            })
            ->leftJoin('teachers', 'subjects.teacher_id', '=', 'teachers.id')
            ->where('students.admited', 1)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('students.name', 'like', "%{$search}%")
                        ->orWhere('students.lrn', 'like', "%{$search}%")
                        ->orWhere('classes.name', 'like', "%{$search}%")
                        ->orWhere('grade_levels.name', 'like', "%{$search}%")
                        ->orWhere('academic_years.name', 'like', "%{$search}%")
                        ->orWhere('subjects.name', 'like', "%{$search}%")
                        ->orWhere('subjects.code', 'like', "%{$search}%")
                        ->orWhere('teachers.name', 'like', "%{$search}%");
                });
            })
            ->select([
                'students.id as student_info_id',
                'students.student_id',
                'students.name as student_name',
                'students.lrn',
                'classes.name as class_name',
                'grade_levels.name as grade_level_name',
                'academic_years.name as academic_year_name',
                'subjects.code as subject_code',
                'subjects.name as subject_name',
                'teachers.name as teacher_name',
            ])
            ->orderBy('students.name')
            ->orderBy('subjects.name')
            ->paginate(15)
            ->withQueryString();

        return view('report.grades.grades', [
            'grades' => $grades,
            'search' => $search,
            'gradeDataAvailable' => $this->hasGradeStorage(),
            'gradeDataMessage' => $this->gradeStorageMessage(),
        ]);
    }

    public function gradeApproval(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $approvals = DB::table('classsub as class_subjects')
            ->join('class as classes', 'class_subjects.class_id', '=', 'classes.id')
            ->leftJoin('grlvl as grade_levels', 'classes.grlvl_id', '=', 'grade_levels.id')
            ->leftJoin('acady as academic_years', 'classes.acady_id', '=', 'academic_years.id')
            ->join('subject as subjects', function ($join) {
                $join->on('class_subjects.sub_id', '=', 'subjects.id')
                    ->whereNull('subjects.deleted_at');
            })
            ->leftJoin('teachers', 'subjects.teacher_id', '=', 'teachers.id')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('classes.name', 'like', "%{$search}%")
                        ->orWhere('grade_levels.name', 'like', "%{$search}%")
                        ->orWhere('academic_years.name', 'like', "%{$search}%")
                        ->orWhere('subjects.name', 'like', "%{$search}%")
                        ->orWhere('subjects.code', 'like', "%{$search}%")
                        ->orWhere('teachers.name', 'like', "%{$search}%");
                });
            })
            ->select([
                'class_subjects.id',
                'classes.name as class_name',
                'grade_levels.name as grade_level_name',
                'academic_years.name as academic_year_name',
                'subjects.code as subject_code',
                'subjects.name as subject_name',
                'teachers.name as teacher_name',
            ])
            ->orderBy('classes.name')
            ->orderBy('subjects.name')
            ->paginate(15)
            ->withQueryString();

        return view('report.grades.aproval', [
            'approvals' => $approvals,
            'search' => $search,
            'approvalDataAvailable' => $this->hasApprovalStorage(),
            'approvalDataMessage' => $this->approvalStorageMessage(),
        ]);
    }

    public function topStudent(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $students = DB::table('stinfo as students')
            ->leftJoin('class as classes', 'students.class_id', '=', 'classes.id')
            ->leftJoin('grlvl as grade_levels', 'students.grlvl_id', '=', 'grade_levels.id')
            ->leftJoin('acady as academic_years', 'students.acady_id', '=', 'academic_years.id')
            ->where('students.admited', 1)
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('students.name', 'like', "%{$search}%")
                        ->orWhere('students.lrn', 'like', "%{$search}%")
                        ->orWhere('classes.name', 'like', "%{$search}%")
                        ->orWhere('grade_levels.name', 'like', "%{$search}%")
                        ->orWhere('academic_years.name', 'like', "%{$search}%");
                });
            })
            ->select([
                'students.id',
                'students.student_id',
                'students.name as student_name',
                'students.lrn',
                'classes.name as class_name',
                'grade_levels.name as grade_level_name',
                'academic_years.name as academic_year_name',
            ])
            ->orderBy('students.name')
            ->paginate(15)
            ->withQueryString();

        return view('report.performace.topstudent', [
            'students' => $students,
            'search' => $search,
            'rankingAvailable' => $this->hasGradeStorage(),
            'rankingMessage' => $this->rankingStorageMessage('student rankings'),
        ]);
    }

    public function topClass(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $classes = DB::table('class as classes')
            ->leftJoin('grlvl as grade_levels', 'classes.grlvl_id', '=', 'grade_levels.id')
            ->leftJoin('acady as academic_years', 'classes.acady_id', '=', 'academic_years.id')
            ->leftJoin('stinfo as students', function ($join) {
                $join->on('students.class_id', '=', 'classes.id')
                    ->where('students.admited', 1);
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('classes.name', 'like', "%{$search}%")
                        ->orWhere('grade_levels.name', 'like', "%{$search}%")
                        ->orWhere('academic_years.name', 'like', "%{$search}%");
                });
            })
            ->select([
                'classes.id',
                'classes.name as class_name',
                'grade_levels.name as grade_level_name',
                'academic_years.name as academic_year_name',
                DB::raw('COUNT(students.id) as student_count'),
            ])
            ->groupBy('classes.id', 'classes.name', 'grade_levels.name', 'academic_years.name')
            ->orderByDesc('student_count')
            ->orderBy('classes.name')
            ->paginate(15)
            ->withQueryString();

        return view('report.performace.topclass', [
            'classes' => $classes,
            'search' => $search,
            'rankingAvailable' => $this->hasGradeStorage(),
            'rankingMessage' => $this->rankingStorageMessage('class rankings'),
        ]);
    }

    private function hasGradeStorage(): bool
    {
        return Collection::make([
            'grades',
            'student_grades',
            'grade_records',
            'class_grades',
        ])->contains(fn (string $table) => Schema::hasTable($table));
    }

    private function hasApprovalStorage(): bool
    {
        return Collection::make([
            'grade_approvals',
            'gradeapproval',
            'grade_approval',
        ])->contains(fn (string $table) => Schema::hasTable($table));
    }

    private function gradeStorageMessage(): string
    {
        return $this->hasGradeStorage()
            ? 'Grade storage was detected.'
            : 'No existing grade records table was found. The report lists real enrolled students, classes, subjects, academic years, and teachers; numeric grades remain unavailable until grade encoding storage is implemented.';
    }

    private function approvalStorageMessage(): string
    {
        return $this->hasApprovalStorage()
            ? 'Grade approval storage was detected.'
            : 'No existing grade approval workflow table was found. The report lists real class-subject assignments that would need approval records once the workflow is implemented.';
    }

    private function rankingStorageMessage(string $rankingName): string
    {
        return $this->hasGradeStorage()
            ? 'Grade storage was detected.'
            : "No existing grade records table was found, so {$rankingName} cannot be computed yet. The table below shows real records without a calculated GWA.";
    }
}
