<?php

declare(strict_types=1);

namespace App\Commands\Authentication;

use App\Data\Authentication\LoginData;
use Illuminate\Support\Facades\Auth;

class LoginCommand
{
    public function execute(LoginData $data): bool
    {
        $is_authenticated = Auth::attempt([
            'email' => $data->email,
            'password' => $data->password,
        ]);
        if (! $is_authenticated) {
            return false;
        }

        session()->regenerate();
        $this->setOrganizationIdInSession();

        return true;
    }

    private function setOrganizationIdInSession(): void
    {
        $default_organization = Auth::user()->organizations()->first();
        session(['organization_id' => $default_organization->id]);
    }
}
