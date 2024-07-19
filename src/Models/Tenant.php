<?php

namespace JuniorFontenele\LaravelMultitenancy\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function getTable()
    {
        return config('multitenancy.tenants_table_name', parent::getTable());
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
                app(config('multitenancy.users_model'))::class,
                config('multitenancy.pivot_table_name'),
                config('multitenancy.tenant_foreign_key'),
                config('multitenancy.users_foreign_key')
            )
            ->using(config('multitenancy.pivot_model'))
            ->withPivot(config('hascreator.column_name'))
            ->withTimestamps();
    }

    public function hosts(): HasMany
    {
        return $this->hasMany(config('multitenancy.hosts_model'), config('multitenancy.tenant_foreign_key'));
    }

    public function assignUser(Authenticatable $user): void
    {
        $this->users()->attach($user);
    }

    public function removeUser(Authenticatable $user): void
    {
        $this->users()->detach($user);
    }
}
