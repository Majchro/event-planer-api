<?php

declare(strict_types=1);

namespace App\Http\Controllers\Authentication;

use App\Commands\Authentication\RegisterCommand;
use App\Data\Authentication\RegisterData;
use App\Enums\ApiResponseStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    public function register(RegisterData $data, RegisterCommand $command): JsonResponse
    {
        $command->execute($data);

        return response()->json([
            'status' => ApiResponseStatus::Success,
        ], Response::HTTP_CREATED);
    }
}
