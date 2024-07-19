<?php

namespace JuniorFontenele\LaravelMultitenancy\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait BelongsToManyTenants
{
    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(
                app(config('multitenancy.tenants_model'))::class,
                config('multitenancy.pivot_table_name'),
                config('multitenancy.users_foreign_key'),
                config('multitenancy.tenant_foreign_key')
            )
            ->using(config('multitenancy.pivot_model'))
            ->withPivot(config('hascreator.column_name'))
            ->withTimestamps();
    }
}
