<?php

namespace JuniorFontenele\LaravelMultitenancy\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
            config('multitenancy.users_model'),
            config('multitenancy.pivot_table_name'),
            config('multitenancy.tenant_foreign_key'),
            config('multitenancy.users_foreign_key')
        )
            ->using(config('multitenancy.pivot_model'))
            ->withTimestamps();
    }
}
