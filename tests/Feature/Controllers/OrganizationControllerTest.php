<?php

declare(strict_types=1);

use App\Commands\Organization\DeleteOrganizationCommand;
use App\Commands\Organization\UpsertOrganizationCommand;
use App\Enums\UserRole;
use App\Models\Organization;
use App\Models\User;
use Mockery\MockInterface;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('index', function () {
    $organizations = Organization::factory()->count(5)->create();
    $organizations->first()->users()->attach($this->user, ['role' => UserRole::Worker]);

    $this->getJson(route('organization.index'))
        ->assertStatus(200)
        ->assertJsonCount(1);
});

test('show', function () {
    $organization = Organization::factory()->create();
    $organization->users()->attach($this->user, ['role' => UserRole::Worker]);

    $this->getJson(route('organization.show', ['organization' => $organization->id]))
        ->assertStatus(200)
        ->assertJson([
            'name' => $organization->name,
            'tier' => $organization->tier->value,
        ]);
});

test('store', function () {
    $this->partialMock(UpsertOrganizationCommand::class, function (MockInterface $mock) {
        $mock->shouldReceive('execute')
            ->andReturn(Organization::factory()->make());
    });

    $this->postJson(route('organization.store'), [
        'name' => 'New organization',
        'tier' => 1,
    ])
        ->assertStatus(200)
        ->assertJson(['status' => 'success']);
});

test('update', function () {
    $this->partialMock(UpsertOrganizationCommand::class, function (MockInterface $mock) {
        $mock->shouldReceive('execute')
            ->andReturn(Organization::factory()->make());
    });
    $organization = Organization::factory()->create();
    $organization->users()->attach($this->user, ['role' => UserRole::Manager]);

    $this->putJson(route('organization.update', ['organization' => $organization->id]), [
        'name' => 'Updated organization',
        'tier' => 1,
    ])
        ->assertStatus(200)
        ->assertJson(['status' => 'success']);
});

test('delete', function () {
    $this->partialMock(DeleteOrganizationCommand::class, function (MockInterface $mock) {
        $mock->shouldReceive('execute')
            ->andReturn(true);
    });
    $organization = Organization::factory()->create();
    $organization->users()->attach($this->user, ['role' => UserRole::Manager]);

    $this->deleteJson(route('organization.destroy', ['organization' => $organization->id]))
        ->assertStatus(200)
        ->assertJson(['status' => 'success']);
});
