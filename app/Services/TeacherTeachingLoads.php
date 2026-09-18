<?php

namespace App\Services;

use App\Models\ClassSubject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Builder;

class TeacherTeachingLoads
{
    public function forTeacher(Teacher $teacher): Builder
    {
        return ClassSubject::query()
            ->where('teacher_id', $teacher->getKey())
            ->whereHas('subject')
            ->whereHas('schoolClass');
    }

    public function owns(Teacher $teacher, int $classId, int $subjectId): bool
    {
        return $this->forTeacher($teacher)
            ->where('class_id', $classId)
            ->where('sub_id', $subjectId)
            ->exists();
    }
}
