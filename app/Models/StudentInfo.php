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
        'enlisted',
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
}
