<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackSubject extends Model
{
    protected $table = 'tracksub';

    protected $fillable = [
        'track_id',
        'grlvl_id',
        'subject_id',
    ];

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function gradeLevel(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class, 'grlvl_id');
    }
}
