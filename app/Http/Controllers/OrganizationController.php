<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Commands\Organization\DeleteOrganizationCommand;
use App\Commands\Organization\UpsertOrganizationCommand;
use App\Data\OrganizationData;
use App\Enums\ApiResponseStatus;
use App\Models\Organization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Organization::class);
        $organizations = $request->user()->organizations()->get();

        return response()->json(OrganizationData::collection($organizations));
    }

    public function show(int $id): JsonResponse
    {
        $organization = Organization::findOrFail($id);
        $this->authorize('view', $organization);

        return response()->json(OrganizationData::from($organization));
    }

    public function store(OrganizationData $data, UpsertOrganizationCommand $command): JsonResponse
    {
        $this->authorize('create', Organization::class);
        $organization = $command->execute($data);

        return response()->json([
            'status' => ApiResponseStatus::Success,
            'data' => OrganizationData::from($organization),
        ]);
    }

    public function update(int $id, OrganizationData $data, UpsertOrganizationCommand $command): JsonResponse
    {
        $organization = Organization::findOrFail($id);
        $this->authorize('update', $organization);
        $organization = $command->execute($data);

        return response()->json([
            'status' => ApiResponseStatus::Success,
            'data' => OrganizationData::from($organization),
        ]);
    }

    public function destroy(int $id, DeleteOrganizationCommand $command): JsonResponse
    {
        $organization = Organization::findOrFail($id);
        $this->authorize('delete', $organization);
        $command->execute($id);

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ]);
    }
}
