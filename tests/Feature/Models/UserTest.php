<?php

declare(strict_types=1);

use App\Enums\UserRole;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->organizations = Organization::factory()->count(5)->create();
    $this->organizations
        ->each(fn ($organization) => $organization->users()->attach($this->user, ['role' => UserRole::Worker]));
});

describe('defaultOrganization', function () {
    test('user has default organization without session', function () {
        expect($this->user->defaultOrganization()->id)
            ->toBe($this->user->organizations()->first()->id);
    });

    test('user has session organization as default', function () {
        $organization = $this->organizations->slice(2, 1)->first();
        $this->actingAs($this->user)
            ->withSession(['organization_id' => $organization->id]);

        expect(Auth::user()->defaultOrganization()->id)
            ->toBe($organization->id);
    });
});
