<?php

declare(strict_types=1);

use App\Commands\Authentication\LoginCommand;
use App\Commands\Authentication\LogoutCommand;
use App\Models\User;
use Mockery\MockInterface;

describe('login', function () {
    test('return 200 if user exists', function () {
        $user = User::factory()->create();
        $this->partialMock(LoginCommand::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')->andReturnTrue();
        });

        $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'zaq1@WSX',
        ])
            ->assertStatus(200);
    });

    test('return 401 if user don\'t exists', function () {
        $user = User::factory()->create();
        $this->partialMock(LoginCommand::class, function (MockInterface $mock) {
            $mock->shouldReceive('execute')->andReturnFalse();
        });

        $this->postJson(route('auth.login'), [
            'email' => $user->email,
            'password' => 'zaq1@WSX',
        ])
            ->assertStatus(401);
    });
});

test('logout', function () {
    $this->partialMock(LogoutCommand::class, function (MockInterface $mock) {
        $mock->shouldReceive('execute');
    });

    $this->postJson(route('auth.logout'))
        ->assertStatus(200);
});
