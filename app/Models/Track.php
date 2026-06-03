<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Track extends Model
{
    protected $table = 'track';

    protected $fillable = [
        'name',
    ];

    public function trackSubjects(): HasMany
    {
        return $this->hasMany(TrackSubject::class, 'track_id');
    }
}
