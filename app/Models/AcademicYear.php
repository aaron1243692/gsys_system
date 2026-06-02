<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $table = 'acady';

    protected $fillable = [
        'name',
        'year_from',
        'year_to',
    ];
}
