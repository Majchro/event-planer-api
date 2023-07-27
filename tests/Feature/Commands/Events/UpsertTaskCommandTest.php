<?php

declare(strict_types=1);

use App\Commands\Events\UpsertTaskCommand;
use App\Data\TaskData;
use App\Enums\UserRole;
use App\Models\Events\Task;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->organization = Organization::factory()->create();
    $this->organization->users()->attach($this->user, ['role' => UserRole::Worker]);
});

it('will create task', function () {
    $date = Carbon::now()->addDay()->setMicroseconds(0);
    $data = TaskData::from([
        'title' => 'Test title',
        'description' => 'Test description',
        'date' => $date->toIso8601String(),
    ]);
    $task = (new UpsertTaskCommand)->execute($this->user, $data);

    expect($task->toArray())
        ->toMatchArray([
            'title' => 'Test title',
            'description' => 'Test description',
            'date' => $date->toISOString(),
        ]);
});

it('will update task', function () {
    $task = Task::factory()->create([
        'user_id' => $this->user->id,
        'organization_id' => $this->organization->id,
    ]);
    $data = TaskData::from([
        'id' => $task->id,
        'title' => 'Updated title',
        'description' => 'Test description',
        'date' => Carbon::now()->addDay()->toIso8601String(),
    ]);
    $task = (new UpsertTaskCommand)->execute($this->user, $data);

    expect($task->fresh()->title)
        ->toBe('Updated title');
});
