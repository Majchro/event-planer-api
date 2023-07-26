<?php

declare(strict_types=1);

use App\Commands\Authentication\RegisterCommand;
use App\Data\Authentication\RegisterData;
use App\Models\User;

it('will create user', function () {
    $data = RegisterData::from([
        'name' => 'Test User',
        'email' => 'test@email.com',
        'password' => 'zaq1@WSX',
    ]);
    $user = (new RegisterCommand)->execute($data);

    expect(User::latest('id')->first()->id)
        ->toBe($user->id);
});
