<?php

declare(strict_types=1);

use App\Commands\Authentication\LogoutCommand;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

it('will logout user', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    (new LogoutCommand)->execute();

    expect(Auth::check())
        ->toBeFalse();
});
