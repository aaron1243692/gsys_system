<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guardian extends Authenticatable
{
    protected $fillable = [
        'username',
        'email',
        'password',
        'name',
        'contact',
        'address',
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

    public function children(): HasMany
    {
        return $this->hasMany(GuardianChild::class, 'guardian_id');
    }
}
