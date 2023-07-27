<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Commands\Events\DeleteTaskCommand;
use App\Commands\Events\UpsertTaskCommand;
use App\Data\TaskData;
use App\Enums\ApiResponseStatus;
use App\Models\Events\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Task::class);
        $user = $request->user();
        $tasks = $user
            ->tasks()
            ->where('organization_id', $user->defaultOrganization()->id)
            ->get();

        return response()->json(TaskData::collection($tasks));
    }

    public function show(int $id): JsonResponse
    {
        $task = Task::findOrFail($id);
        $this->authorize('view', $task);

        return response()->json(TaskData::from($task));
    }

    public function store(TaskData $data, UpsertTaskCommand $command): JsonResponse
    {
        $this->authorize('create', Task::class);
        $task = $command->execute(Auth::user(), $data);

        return response()->json([
            'status' => ApiResponseStatus::Success,
            'data' => TaskData::from($task),
        ]);
    }

    public function update(int $id, TaskData $data, UpsertTaskCommand $command): JsonResponse
    {
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);
        $task = $command->execute(Auth::user(), $data);

        return response()->json([
            'status' => ApiResponseStatus::Success,
            'data' => TaskData::from($task),
        ]);
    }

    public function destroy(int $id, DeleteTaskCommand $command): JsonResponse
    {
        $task = Task::findOrFail($id);
        $this->authorize('delete', $task);
        $command->execute($id);

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ]);
    }
}
