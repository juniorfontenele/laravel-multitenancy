<?php

namespace JuniorFontenele\LaravelMultitenancy\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TenantHost extends Model
{
    use HasFactory;

    protected $fillable = [
        'host',
    ];

    public function getTable()
    {
        return config('multitenancy.hosts_table_name', parent::getTable());
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(config('multitenancy.tenants_model'), config('multitenancy.tenant_foreign_key'));
    }
}
