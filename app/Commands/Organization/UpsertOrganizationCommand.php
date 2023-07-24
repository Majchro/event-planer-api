<?php

declare(strict_types=1);

namespace App\Commands\Organization;

use App\Data\OrganizationData;
use App\Enums\OrganizationTier;
use App\Models\Organization;

class UpsertOrganizationCommand
{
    public function execute(OrganizationData $data): Organization
    {
        $organization = Organization::updateOrCreate([
            'id' => $data->id,
        ], [
            'name' => $data->name,
            'tier' => $data->tier,
            'users_limit' => $this->getUsersLimit($data->tier),
        ]);

        return $organization;
    }

    private function getUsersLimit(OrganizationTier $tier): int
    {
        return match ($tier) {
            OrganizationTier::Free => 3,
            OrganizationTier::Business => 10,
            OrganizationTier::Enterprise => 100,
        };
    }
}
