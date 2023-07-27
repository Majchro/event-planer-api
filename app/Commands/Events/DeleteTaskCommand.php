<?php

declare(strict_types=1);

namespace App\Commands\Events;

use App\Models\Events\Task;

class DeleteTaskCommand
{
    public function execute(int $id): bool
    {
        $task = Task::findOrFail($id);

        return $task->delete();
    }
}
