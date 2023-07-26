<?php

declare(strict_types=1);

namespace App\Commands\Authentication;

use App\Data\Authentication\RegisterData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterCommand
{
    public function execute(RegisterData $data): User
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
    }
}
