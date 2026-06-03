<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curriculum extends Model
{
    protected $table = 'curriculum';

    protected $fillable = [
        'name',
        'track_id',
        'batch_id',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function curriculumSubjects(): HasMany
    {
        return $this->hasMany(CurriculumSubject::class, 'curriculum_id');
    }
}
