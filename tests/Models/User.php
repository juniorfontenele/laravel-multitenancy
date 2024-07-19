<?php

namespace JuniorFontenele\LaravelMultitenancy\Tests\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use JuniorFontenele\LaravelMultitenancy\Traits\BelongsToManyTenants;

class User extends Authenticatable
{
    use BelongsToManyTenants;

    protected $fillable = [
        'name',
        'email',
    ];
}
