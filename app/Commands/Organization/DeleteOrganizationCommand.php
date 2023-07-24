<?php

declare(strict_types=1);

namespace App\Commands\Organization;

use App\Models\Organization;

class DeleteOrganizationCommand
{
    public function execute(int $id): bool
    {
        $organization = Organization::findOrFail($id);

        return $organization->delete();
    }
}
