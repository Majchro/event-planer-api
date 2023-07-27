<?php

declare(strict_types=1);

use App\Commands\Authentication\LoginCommand;
use App\Data\Authentication\LoginData;
use App\Enums\UserRole;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->organization = Organization::factory()->create();
    $this->organization->users()->attach($this->user, ['role' => UserRole::Manager]);
});

it('will login user', function () {
    $data = LoginData::from([
        'email' => $this->user->email,
        'password' => 'zaq1@WSX',
    ]);
    (new LoginCommand)->execute($data);

    expect(Auth::check())
        ->toBeTrue();
});

it('will return false if data is wrong', function () {
    $data = LoginData::from([
        'email' => $this->user->email,
        'password' => 'zaq1@WSX123',
    ]);
    (new LoginCommand)->execute($data);

    expect(Auth::check())
        ->toBeFalse();
});

it('will set first organization as default', function () {
    $organization = Organization::factory()->create();
    $organization->users()->attach($this->user, ['role' => UserRole::Manager]);
    $data = LoginData::from([
        'email' => $this->user->email,
        'password' => 'zaq1@WSX',
    ]);
    (new LoginCommand)->execute($data);

    expect(session()->get('organization_id'))
        ->toBe($this->organization->id);
});
