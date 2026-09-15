<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Authenticatable
{
    protected static function booted(): void
    {
        static::creating(function ($student) { $student->student_number = (string) random_int(10000000000, 99999999999); });
        static::updating(function ($student) {
            if ($student->isDirty('student_number')) throw new \LogicException('Student Number is permanent.');
        });
    }
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function info(): HasOne
    {
        return $this->hasOne(StudentInfo::class, 'student_id');
    }
}
