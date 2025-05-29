<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Interfaces\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Obtener el perfil del usuario autenticado
     */
    public function show(): JsonResponse
    {
        $user = $this->userService->getUserProfile(Auth::id());
        return response()->json($user);
    }

    /**
     * Actualizar el perfil del usuario
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = $this->userService->updateUserProfile(Auth::id(), $request->validated());
        
        return response()->json([
            'message' => 'Perfil actualizado correctamente',
            'user' => $user
        ]);
    }

    /**
     * Obtener las estadísticas del usuario
     */
    public function getStats(): JsonResponse
    {
        $stats = $this->userService->getUserStats(Auth::id());
        return response()->json($stats);
    }
}
