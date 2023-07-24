<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Organization;
use App\Models\OrganizationUser;
use App\Models\User;

class OrganizationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Organization $organization): bool
    {
        return OrganizationUser::where('organization_id', $organization->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Organization $organization): bool
    {
        return OrganizationUser::where('organization_id', $organization->id)
            ->where('user_id', $user->id)
            ->where('role', UserRole::Manager)
            ->exists();
    }

    public function delete(User $user, Organization $organization): bool
    {
        return OrganizationUser::where('organization_id', $organization->id)
            ->where('user_id', $user->id)
            ->where('role', UserRole::Manager)
            ->exists();
    }

    public function restore(User $user, Organization $organization): bool
    {
        return $user->is_admin;
    }

    public function forceDelete(User $user, Organization $organization): bool
    {
        return $user->is_admin;
    }
}
