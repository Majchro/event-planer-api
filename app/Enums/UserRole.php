<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: int
{
    case Manager = 0;
    case Worker = 1;
}
