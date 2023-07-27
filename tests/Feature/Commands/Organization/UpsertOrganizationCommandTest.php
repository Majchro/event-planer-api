<?php

declare(strict_types=1);

use App\Commands\Organization\UpsertOrganizationCommand;
use App\Data\OrganizationData;
use App\Enums\OrganizationTier;
use App\Models\Organization;

it('will create organization', function () {
    $data = OrganizationData::from([
        'name' => 'Test name',
        'tier' => OrganizationTier::Free,
    ]);
    $organization = (new UpsertOrganizationCommand)->execute($data);

    $this->assertModelExists($organization);
    expect($organization->toArray())
        ->toMatchArray([
            'name' => 'Test name',
            'tier' => OrganizationTier::Free->value,
            'users_limit' => 3,
        ]);
});

it('will update organization', function () {
    $organization = Organization::factory()->create();
    $data = OrganizationData::from([
        'id' => $organization->id,
        'name' => 'Edited name',
        'tier' => OrganizationTier::Business,
    ]);
    (new UpsertOrganizationCommand)->execute($data);

    expect($organization->fresh()->toArray())
        ->toMatchArray([
            'name' => 'Edited name',
            'tier' => OrganizationTier::Business->value,
        ]);
});
