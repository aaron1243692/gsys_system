<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Schema;

class Student extends Authenticatable
{
    protected static function booted(): void
    {
        static::creating(function ($student) {
            if (Schema::hasColumn('students', 'student_number') && empty($student->student_number)) {
                $student->student_number = (string) random_int(10000000000, 99999999999);
            }
        });
        static::updating(function ($student) {
            if (Schema::hasColumn('students', 'student_number') && $student->isDirty('student_number')) throw new \LogicException('Student Number is permanent.');
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
