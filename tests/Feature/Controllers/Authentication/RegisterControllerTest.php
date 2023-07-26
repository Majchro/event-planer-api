<?php

declare(strict_types=1);

use App\Commands\Authentication\RegisterCommand;
use Mockery\MockInterface;

test('register', function () {
    $this->partialMock(RegisterCommand::class, function (MockInterface $mock) {
        $mock->shouldReceive('execute');
    });

    $this->postJson(route('auth.register'), [
        'name' => 'Test name',
        'email' => 'test@mail.com',
        'password' => 'zaq1@WSX',
    ])
        ->assertStatus(201);
});
