<?php

namespace Tests;

use App\Models\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

trait WithTenancy
{
    protected function setUpTraits(): array
    {
        $uses = parent::setUpTraits();

        if (isset($uses[WithTenancy::class])) {
            $this->initializeTenancy($uses);
        }

        return $uses;
    }

    protected function initializeTenancy(array $uses): void
    {
        $tenant = Tenant::firstOr(static fn () => Tenant::factory()->create());
        tenancy()->initialize($tenant);

        if (isset($uses[DatabaseTransactions::class]) || isset($uses[RefreshDatabase::class])) {
            $this->beginTenantDatabaseTransaction();
        }

        if (isset($uses[DatabaseMigrations::class]) || isset($uses[RefreshDatabase::class])) {
            $this->beforeApplicationDestroyed(function () use ($tenant) {
                $tenant->delete();
            });
        }
    }

    public function beginTenantDatabaseTransaction(): void
    {
        $database = $this->app->make('db');

        $connection = $database->connection('tenant');
        $dispatcher = $connection->getEventDispatcher();

        $connection->unsetEventDispatcher();
        $connection->beginTransaction();
        $connection->setEventDispatcher($dispatcher);

        $this->beforeApplicationDestroyed(function () use ($database) {
            $connection = $database->connection('tenant');
            $dispatcher = $connection->getEventDispatcher();

            $connection->unsetEventDispatcher();
            $connection->rollBack();
            $connection->setEventDispatcher($dispatcher);
            $connection->disconnect();
        });
    }
}
