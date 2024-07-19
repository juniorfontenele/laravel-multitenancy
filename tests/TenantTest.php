<?php

namespace JuniorFontenele\LaravelMultitenancy\Tests;

class TenantTest extends TestCase
{
    public function test_can_create_a_tenant()
    {
        $tenant = $this->createTenant();

        $host = $this->createHost($tenant);

        $user = $this->createUser();

        $tenant->assignUser($user);

        $this->assertDatabaseHas(config('multitenancy.tenants_table_name'), [
            'id' => $tenant->id,
            'name' => $tenant->name,
        ]);

        $this->assertDatabaseHas(config('multitenancy.hosts_table_name'), [
            'id' => $host->id,
            'tenant_id' => $tenant->id,
            'host' => $host->host,
        ]);

        $this->assertDatabaseHas(config('multitenancy.pivot_table_name'), [
            'tenant_id' => $tenant->id,
            'user_id' => $user->id,
        ]);

        $tenant->removeUser($user);

        $this->assertDatabaseMissing(config('multitenancy.pivot_table_name'), [
            'tenant_id' => $tenant->id,
            'user_id' => $user->id,
        ]);
    }
}
