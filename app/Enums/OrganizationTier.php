<?php

declare(strict_types=1);

namespace App\Enums;

enum OrganizationTier: int
{
    case Free = 0;
    case Business = 1;
    case Enterprise = 2;
}
