<?php

declare(strict_types=1);

namespace Database\Factories\Events;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->paragraph(1),
            'description' => fake()->paragraph(6),
            'date' => fake()->date(),
        ];
    }

    public function finished(): Factory
    {
        return $this->state(fn () => ['finished_at' => now()]);
    }
}
