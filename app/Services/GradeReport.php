<?php

namespace App\Services;

use App\Models\Grade;
use Illuminate\Http\Request;

class GradeReport
{
    public function data(Request $request, ?int $studentId = null): array
    {
        $filters = $request->validate([
            'academic_year_id' => ['nullable', 'integer', 'min:1'],
            'grade_level_id' => ['nullable', 'integer', 'min:1'],
            'class_id' => ['nullable', 'integer', 'min:1'],
            'subject_id' => ['nullable', 'integer', 'min:1'],
            'teacher_id' => ['nullable', 'integer', 'min:1'],
            'student_id' => ['nullable', 'integer', 'min:1'],
            'quarter' => ['nullable', 'integer', 'in:1,2,3'],
            'search' => ['nullable', 'string', 'max:150'],
        ]);
        $base = Grade::recorded()->when($studentId !== null, fn ($q) => $q->where('student_id', $studentId));
        if ($studentId !== null) $base->approved();
        $options = [];
        foreach (['academic_year', 'grade_level', 'class', 'subject', 'teacher', 'student'] as $field) {
            $options[$field] = (clone $base)->select($field.'_id', $field.'_name')->distinct()->orderBy($field.'_name')->get();
        }
        $query = clone $base;
        foreach (['academic_year_id', 'grade_level_id', 'class_id', 'subject_id', 'teacher_id', 'student_id', 'quarter'] as $field) {
            if (! empty($filters[$field])) {
                $query->where($field, $filters[$field]);
            }
        }
        if (! empty($filters['search'])) {
            $query->where(fn ($q) => $q->where('student_name', 'like', '%'.$filters['search'].'%')
                ->orWhere('subject_name', 'like', '%'.$filters['search'].'%'));
        }
        $query->select(['student_id', 'class_id', 'subject_id', 'academic_year_id'])
            ->groupBy('student_id', 'class_id', 'subject_id', 'academic_year_id');
        foreach (['student_name', 'class_name', 'subject_name', 'academic_year_name', 'grade_level_name'] as $field) {
            $query->selectRaw("MAX($field) as $field");
        }
        // Pivot unique stored quarter values; no averaging, rounding, or grade calculation.
        foreach ([1, 2, 3] as $quarter) {
            $query->selectRaw("MAX(CASE WHEN quarter = $quarter THEN grade END) as q$quarter")
                ->selectRaw("MAX(CASE WHEN quarter = $quarter THEN remarks END) as remarks$quarter")
                ->selectRaw("MAX(CASE WHEN quarter = $quarter THEN teacher_name END) as teacher$quarter");
        }

        return ['grades' => $query->orderBy('academic_year_id', 'desc')->orderBy('student_name')->orderBy('subject_name')
            ->paginate(20)->withQueryString(), 'options' => $options, 'filters' => $filters];
    }
}
