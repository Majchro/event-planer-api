<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Data;

class TaskData extends Data
{
    public function __construct(
        #[FromRouteParameter('organization')]
        public readonly ?int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly CarbonImmutable $date,
        public readonly ?CarbonImmutable $finished_at,
    ) {
    }
}
