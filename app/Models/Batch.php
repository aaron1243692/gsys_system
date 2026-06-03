<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Batch extends Model
{
    protected $table = 'batch';

    protected $fillable = [
        'year',
        'curriculum_id',
        'track_id',
    ];

    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class, 'curriculum_id');
    }

    public function track(): BelongsTo
    {
        return $this->belongsTo(Track::class, 'track_id');
    }
}
