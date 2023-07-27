<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Organization;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()
        ->create()
        ->fresh();
    $this->organization = Organization::factory()
        ->create()
        ->fresh();
});

test('worker can view any organizations', function () {
    $policy_result = $this->user->can('viewAny', Organization::class);

    expect($policy_result)
        ->toBeTrue();
});

describe('view', function () {
    test('worker can view organization', function () {
        $this->organization->users()->attach($this->user, ['role' => UserRole::Worker]);
        $policy_result = $this->user->can('view', $this->organization);

        expect($policy_result)
            ->toBeTrue();
    });

    test('worker from another organization cannot view organization', function () {
        $user = User::factory()->create();
        $policy_result = $user->cannot('view', $this->organization);

        expect($policy_result)
            ->toBeTrue();
    });
});

test('anyone can create organization', function () {
    $policy_result = $this->user->can('create', Organization::class);

    expect($policy_result)
        ->toBeTrue();
});

describe('update', function () {
    test('manager can update organization', function () {
        $this->organization->users()->attach($this->user, ['role' => UserRole::Manager]);
        $policy_result = $this->user->can('update', $this->organization);

        expect($policy_result)
            ->toBeTrue();
    });

    test('worker cannot update organization', function () {
        $this->organization->users()->attach($this->user, ['role' => UserRole::Worker]);
        $policy_result = $this->user->cannot('update', $this->organization);

        expect($policy_result)
            ->toBeTrue();
    });
});

describe('delete', function () {
    test('manager can delete organization', function () {
        $this->organization->users()->attach($this->user, ['role' => UserRole::Manager]);
        $policy_result = $this->user->can('delete', $this->organization);

        expect($policy_result)
            ->toBeTrue();
    });

    test('worker cannot delete organization', function () {
        $this->organization->users()->attach($this->user, ['role' => UserRole::Worker]);
        $policy_result = $this->user->cannot('delete', $this->organization);

        expect($policy_result)
            ->toBeTrue();
    });
});

describe('restore', function () {
    test('admin can restore organization', function () {
        $user = User::factory()->admin()->create();
        $policy_result = $user->can('restore', $this->organization);

        expect($policy_result)
            ->toBeTrue();
    });

    test('manager cannot restore organization', function () {
        $this->organization->users()->attach($this->user, ['role' => UserRole::Manager]);
        $policy_result = $this->user->cannot('restore', $this->organization);

        expect($policy_result)
            ->toBeTrue();
    });
});

describe('forceDelete', function () {
    test('admin can force delete organization', function () {
        $user = User::factory()->admin()->create();
        $policy_result = $user->can('forceDelete', $this->organization);

        expect($policy_result)
            ->toBeTrue();
    });

    test('manager cannot force delete organization', function () {
        $this->organization->users()->attach($this->user, ['role' => UserRole::Manager]);
        $policy_result = $this->user->cannot('forceDelete', $this->organization);

        expect($policy_result)
            ->toBeTrue();
    });
});
