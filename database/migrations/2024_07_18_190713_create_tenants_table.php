<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(config('multitenancy.tenants_table_name'), function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->creator();
            $table->activeState();
            $table->timestamps();
        });

        Schema::create(config('multitenancy.hosts_table_name'), function (Blueprint $table) {
            $table->id();
            $table->tenant();
            $table->string('host')->unique();
            $table->creator();
            $table->activeState();
            $table->timestamps();
        });

        Schema::create(config('multitenancy.pivot_table_name'), function (Blueprint $table) {
            $table->tenant();
            $table->foreignId(config('multitenancy.users_foreign_key'))
                ->constrained(config('multitenancy.users_table_name'))
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->creator();
            $table->activeState();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('multitenancy.pivot_table_name'));
        Schema::dropIfExists(config('multitenancy.hosts_table_name'));
        Schema::dropIfExists(config('multitenancy.tenants_table_name'));
    }
};
