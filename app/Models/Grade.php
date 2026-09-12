<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['grade' => 'decimal:2', 'quarter' => 'integer'];
    }

    public function scopeRecorded(Builder $query): Builder
    {
        return $query->whereIn('quarter', [1, 2, 3])->whereNotNull('student_id');
    }
}
