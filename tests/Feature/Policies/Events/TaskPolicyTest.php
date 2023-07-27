<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Events\Task;
use App\Models\Organization;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()
        ->create()
        ->fresh();
    $organization = Organization::factory()->create();
    $organization->users()->attach($this->user, ['role' => UserRole::Worker]);
    $this->task = Task::factory()
        ->create([
            'user_id' => $this->user->id,
            'organization_id' => $organization->id,
        ])
        ->fresh();
});

test('user can view any task', function () {
    $policy_result = $this->user->can('viewAny', Task::class);

    expect($policy_result)
        ->toBeTrue();
});

test('user can view task', function () {
    $policy_result = $this->user->can('view', $this->task);

    expect($policy_result)
        ->toBeTrue();
});

test('user can create task', function () {
    $policy_result = $this->user->can('create', Task::class);

    expect($policy_result)
        ->toBeTrue();
});

test('user can update task', function () {
    $policy_result = $this->user->can('update', $this->task);

    expect($policy_result)
        ->toBeTrue();
});

test('user can delete task', function () {
    $policy_result = $this->user->can('delete', $this->task);

    expect($policy_result)
        ->toBeTrue();
});

test('user cannot restore task', function () {
    $policy_result = $this->user->cannot('restore', $this->task);

    expect($policy_result)
        ->toBeTrue();
});

test('user cannot force delete task', function () {
    $policy_result = $this->user->cannot('forceDelete', $this->task);

    expect($policy_result)
        ->toBeTrue();
});
