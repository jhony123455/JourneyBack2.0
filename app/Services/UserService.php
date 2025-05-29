<?php

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService implements UserServiceInterface
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function getUserProfile(int $userId): User
    {
        $user = User::findOrFail($userId);
        
        // Si el usuario tiene un avatar, convertirlo a base64
        if ($user->avatar) {
            $user->avatar = $this->imageService->getImageAsBase64($user->avatar);
        }
        
        return $user;
    }

    public function updateUserProfile(int $userId, array $data): User
    {
        $user = User::findOrFail($userId);

        // Si se proporciona una nueva imagen de avatar
        if (isset($data['avatar']) && Str::startsWith($data['avatar'], 'data:image')) {
            // Eliminar el avatar anterior si existe
            if ($user->avatar) {
                $this->imageService->deleteImage($user->avatar);
            }
            
            // Guardar la nueva imagen y actualizar la ruta
            $data['avatar'] = $this->imageService->saveImage($data['avatar'], 'avatars');
        }

        $user->update($data);
        return $this->getUserProfile($userId); // Retornar con el avatar en base64
    }

    public function getUserStats(int $userId): array
    {
        $user = User::findOrFail($userId);

        // Obtener estadísticas de actividades
        $activityStats = DB::table('activities')
            ->where('user_id', $userId)
            ->select(
                DB::raw('COUNT(*) as total_activities'),
                DB::raw('COUNT(DISTINCT color) as unique_colors')
            )
            ->first();

        // Obtener estadísticas de eventos del calendario
        $eventStats = DB::table('calendar_events')
            ->where('user_id', $userId)
            ->select(
                DB::raw('COUNT(*) as total_events'),
                DB::raw('COUNT(DISTINCT DATE(start_date)) as unique_days')
            )
            ->first();

        // Obtener estadísticas de etiquetas
        $tagStats = DB::table('tags')
            ->where('user_id', $userId)
            ->count();

        // Obtener estadísticas del diario
        $diaryStats = DB::table('diary_entries')
            ->where('user_id', $userId)
            ->select(
                DB::raw('COUNT(*) as total_entries'),
                DB::raw('COUNT(DISTINCT DATE(entry_date)) as unique_dates'),
                DB::raw('COUNT(DISTINCT color) as unique_colors')
            )
            ->first();

        return [
            'profile_completion' => $user->getProfileCompletionPercentage(),
            'activities' => [
                'total' => $activityStats->total_activities ?? 0,
                'unique_colors' => $activityStats->unique_colors ?? 0
            ],
            'calendar' => [
                'total_events' => $eventStats->total_events ?? 0,
                'unique_days' => $eventStats->unique_days ?? 0
            ],
            'tags' => [
                'total' => $tagStats
            ],
            'diary' => [
                'total_entries' => $diaryStats->total_entries ?? 0,
                'unique_dates' => $diaryStats->unique_dates ?? 0,
                'unique_colors' => $diaryStats->unique_colors ?? 0
            ]
        ];
    }
} 