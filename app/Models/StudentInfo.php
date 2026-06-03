<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentInfo extends Model
{
    protected $table = 'stinfo';

    protected $fillable = [
        'student_id',
        'lrn',
        'admited',
        'name',
        'gender',
        'birthdate',
        'grlvl_id',
        'class_id',
        'acady_id',
        'contact',
        'address',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function gradeLevel(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class, 'grlvl_id');
    }

    public function schoolClass(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'acady_id');
    }
}
