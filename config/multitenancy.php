<?php

return [
    'tenants_model' => \JuniorFontenele\LaravelMultitenancy\Models\Tenant::class,

    'tenants_table_name' => 'tenants',

    'tenant_foreign_key' => 'tenant_id',

    'hosts_model' => \JuniorFontenele\LaravelMultitenancy\Models\TenantHost::class,

    'hosts_table_name' => 'tenant_hosts',

    'users_model' => \App\Models\User::class,

    'users_foreign_key' => 'user_id',

    'pivot_model' => \JuniorFontenele\LaravelMultitenancy\Models\TenantUser::class,

    'pivot_table_name' => 'tenant_user',
];
