<?php

declare(strict_types=1);

use App\Commands\Events\DeleteTaskCommand;
use App\Commands\Events\UpsertTaskCommand;
use App\Enums\UserRole;
use App\Models\Events\Task;
use App\Models\Organization;
use App\Models\User;
use Carbon\Carbon;
use Mockery\MockInterface;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->organization = Organization::factory()->create();
    $this->organization->users()->attach($this->user, ['role' => UserRole::Worker]);
    $this->actingAs($this->user);
});

test('index', function () {
    Task::factory()->count(5)->create([
        'user_id' => $this->user->id,
        'organization_id' => $this->organization->id,
    ]);

    $this->getJson(route('tasks.index'))
        ->assertStatus(200)
        ->assertJsonCount(5);
});

test('show', function () {
    $tasks = Task::factory()->count(5)->create([
        'user_id' => $this->user->id,
        'organization_id' => $this->organization->id,
    ]);
    $task = $tasks->first();

    $this->getJson(route('tasks.show', ['task' => $task->id]))
        ->assertStatus(200)
        ->assertJson([
            'title' => $task->title,
        ]);
});

test('store', function () {
    $this->partialMock(UpsertTaskCommand::class, function (MockInterface $mock) {
        $mock->shouldReceive('execute')
            ->andReturn(Task::factory()->make([
                'user_id' => $this->user->id,
                'organization_id' => $this->organization->id,
            ]));
    });

    $this->postJson(route('tasks.store'), [
        'title' => 'New task',
        'description' => 'Easy task',
        'date' => Carbon::now()->toIso8601String(),
    ])
        ->assertStatus(200)
        ->assertJson(['status' => 'success']);
});

test('update', function () {
    $this->partialMock(UpsertTaskCommand::class, function (MockInterface $mock) {
        $mock->shouldReceive('execute')
            ->andReturn(Task::factory()->make([
                'user_id' => $this->user->id,
                'organization_id' => $this->organization->id,
            ]));
    });
    $task = Task::factory()->create([
        'user_id' => $this->user->id,
        'organization_id' => $this->organization->id,
    ]);

    $this->putJson(route('tasks.update', ['task' => $task->id]), [
        'title' => 'New task',
        'description' => 'Easy task',
        'date' => Carbon::now()->toIso8601String(),
    ])
        ->assertStatus(200)
        ->assertJson(['status' => 'success']);
});

test('delete', function () {
    $this->partialMock(DeleteTaskCommand::class, function (MockInterface $mock) {
        $mock->shouldReceive('execute')
            ->andReturn(true);
    });
    $task = Task::factory()->create([
        'user_id' => $this->user->id,
        'organization_id' => $this->organization->id,
    ]);

    $this->deleteJson(route('tasks.destroy', ['task' => $task->id]))
        ->assertStatus(200)
        ->assertJson(['status' => 'success']);
});
