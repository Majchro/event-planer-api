<?php

declare(strict_types=1);

use App\Commands\Organization\DeleteOrganizationCommand;
use App\Models\Organization;

it('will delete organization', function () {
    $organization = Organization::factory()->create();
    (new DeleteOrganizationCommand)->execute($organization->id);

    expect(Organization::find($organization->id))
        ->toBeNull();
});
