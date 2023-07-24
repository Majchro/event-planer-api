<?php

declare(strict_types=1);

namespace App\Data;

use App\Enums\OrganizationTier;
use Spatie\LaravelData\Attributes\FromRouteParameter;
use Spatie\LaravelData\Attributes\Validation\Prohibited;
use Spatie\LaravelData\Data;

class OrganizationData extends Data
{
    public function __construct(
        #[FromRouteParameter('organization')]
        public readonly ?int $id,
        public readonly string $name,
        public readonly OrganizationTier $tier,
        #[Prohibited]
        public readonly ?int $users_limit,
    ) {
    }
}
