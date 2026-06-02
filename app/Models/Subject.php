<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use SoftDeletes;

    protected $table = 'subject';

    protected $fillable = [
        'subcat_id',
        'teacher_id',
        'name',
        'code',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SubjectCategory::class, 'subcat_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}
