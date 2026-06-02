<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeLevel extends Model
{
    protected $table = 'grlvl';

    protected $fillable = [
        'name',
    ];
}
