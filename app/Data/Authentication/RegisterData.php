<?php

declare(strict_types=1);

namespace App\Data\Authentication;

use Spatie\LaravelData\Attributes\Validation\Password;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;

class RegisterData extends Data
{
    public function __construct(
        public readonly string $name,
        #[Unique('users', 'email')]
        public readonly string $email,
        #[Password(
            min: 8,
            letters: true,
            mixedCase: true,
            numbers: true,
            symbols: true,
        )]
        public readonly string $password,
    ) {
    }
}
