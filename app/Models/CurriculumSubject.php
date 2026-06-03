<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurriculumSubject extends Model
{
    protected $table = 'curriculum_subjects';

    protected $fillable = [
        'curriculum_id',
        'subject_id',
        'grade_level',
        'semester',
        'units',
        'sort_order',
        'prerequisites',
    ];

    protected function casts(): array
    {
        return [
            'units' => 'decimal:1',
        ];
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }
}
