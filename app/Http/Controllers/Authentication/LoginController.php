<?php

declare(strict_types=1);

namespace App\Http\Controllers\Authentication;

use App\Commands\Authentication\LoginCommand;
use App\Commands\Authentication\LogoutCommand;
use App\Data\Authentication\LoginData;
use App\Enums\ApiResponseStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function login(LoginData $data, LoginCommand $command): JsonResponse
    {
        $is_authenticated = $command->execute($data);
        if ($is_authenticated) {
            return response()->json(['status' => ApiResponseStatus::Success]);
        }

        return response()->json([
            'status' => ApiResponseStatus::Error,
            'message' => __('auth.failed'),
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function logout(LogoutCommand $command): JsonResponse
    {
        $command->execute();

        return response()->json(['status' => ApiResponseStatus::Success]);
    }
}
