<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolClass extends Model
{
    protected $table = 'class';

    protected $fillable = [
        'grlvl_id',
        'track_id',
        'acady_id',
        'adviser_id',
        'name',
    ];

    public function gradeLevel(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class, 'grlvl_id');
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'acady_id');
    }

    public function adviser(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'adviser_id');
    }

    public function classSubjects(): HasMany
    {
        return $this->hasMany(ClassSubject::class, 'class_id');
    }

    public function classSchedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class, 'class_id');
    }
}
