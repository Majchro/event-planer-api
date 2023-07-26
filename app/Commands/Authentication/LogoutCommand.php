<?php

declare(strict_types=1);

namespace App\Commands\Authentication;

use Illuminate\Support\Facades\Auth;

class LogoutCommand
{
    public function execute(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}
