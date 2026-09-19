<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileApiToken extends Model
{
    protected $fillable = ['account_type', 'account_id', 'token_hash', 'last_used_at', 'expires_at'];

    protected function casts(): array
    {
        return ['last_used_at' => 'datetime', 'expires_at' => 'datetime'];
    }
}
