<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectCategory extends Model
{
    protected $table = 'subcat';

    protected $fillable = [
        'name',
    ];
}
