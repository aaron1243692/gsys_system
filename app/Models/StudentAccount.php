<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;

class StudentAccount extends Authenticatable
{
    protected $fillable = [
        'student_id', 'username', 'email', 'password', 'name', 'birthdate',
        'gender', 'contact', 'address', 'requested_grlvl_id', 'requested_acady_id',
    ];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return ['password' => 'hashed', 'birthdate' => 'date'];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
