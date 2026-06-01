<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Contracts\Permission as PermissionContract;
use Spatie\Permission\Exceptions\PermissionAlreadyExists;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Guard;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    protected $guarded = [];

    public static function create(array $attributes = []): PermissionContract
    {
        $attributes['guard_name'] ??= Guard::getDefaultName(static::class);
        $attributes['codename'] ??= $attributes['name'] ?? null;

        $permission = static::query()
            ->where('codename', $attributes['codename'])
            ->first();

        if ($permission) {
            throw PermissionAlreadyExists::create($attributes['codename'], $attributes['guard_name']);
        }

        return static::query()->create($attributes);
    }

    public static function findByName(string $name, ?string $guardName = null): PermissionContract
    {
        $guardName ??= Guard::getDefaultName(static::class);

        $permission = static::getPermission([
            'codename' => $name,
            'guard_name' => $guardName,
        ]);

        if (! $permission || $permission->isGroup()) {
            throw PermissionDoesNotExist::create($name, $guardName);
        }

        return $permission;
    }

    public static function findById(int|string $id, ?string $guardName = null): PermissionContract
    {
        $guardName ??= Guard::getDefaultName(static::class);

        $permission = static::getPermission([
            (new static)->getKeyName() => $id,
            'guard_name' => $guardName,
        ]);

        if (! $permission || $permission->isGroup()) {
            throw PermissionDoesNotExist::withId($id, $guardName);
        }

        return $permission;
    }

    public static function findOrCreate(string $name, ?string $guardName = null): PermissionContract
    {
        $guardName ??= Guard::getDefaultName(static::class);

        $permission = static::query()
            ->where('codename', $name)
            ->where('guard_name', $guardName)
            ->whereNotNull('parent_id')
            ->first();

        if (! $permission) {
            return static::query()->create([
                'name' => str($name)->replace('.', ' ')->headline()->toString(),
                'codename' => $name,
                'parent_id' => null,
                'guard_name' => $guardName,
            ]);
        }

        return $permission;
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function isGroup(): bool
    {
        return $this->parent_id === null;
    }

    public function isAssignable(): bool
    {
        return ! $this->isGroup();
    }
}
