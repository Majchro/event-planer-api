<?php

declare(strict_types=1);

use App\Commands\Events\DeleteTaskCommand;
use App\Enums\UserRole;
use App\Models\Events\Task;
use App\Models\Organization;
use App\Models\User;

beforeEach(function () {

});

it('will delete task', function () {
    $user = User::factory()->create();
    $organization = Organization::factory()->create();
    $organization->users()->attach($user, ['role' => UserRole::Worker]);
    $task = Task::factory()->create([
        'user_id' => $user->id,
        'organization_id' => $organization->id,
    ]);
    (new DeleteTaskCommand)->execute($task->id);

    $this->assertModelMissing($task);
});
