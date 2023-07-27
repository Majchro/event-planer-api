<?php

declare(strict_types=1);

namespace App\Commands\Events;

use App\Data\TaskData;
use App\Models\Events\Task;
use App\Models\User;

class UpsertTaskCommand
{
    public function execute(User $user, TaskData $data): Task
    {
        return Task::updateOrCreate([
            'id' => $data->id,
        ], [
            'title' => $data->title,
            'description' => $data->description,
            'date' => $data->date,
            'user_id' => $user->id,
            'organization_id' => $user->defaultOrganization()->id,
        ]);
    }
}
