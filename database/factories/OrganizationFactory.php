<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\OrganizationTier;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'tier' => OrganizationTier::Free,
            'users_limit' => 10,
        ];
    }

    public function tier(OrganizationTier $tier): Factory
    {
        return $this->state(fn (array $attributes) => ['tier' => $tier]);
    }
}
