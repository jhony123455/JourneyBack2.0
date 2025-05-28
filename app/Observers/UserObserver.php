<?php

namespace App\Observers;

use App\Models\User;
use Database\Seeders\DefaultDiaryColorsSeeder;
use Illuminate\Support\Facades\DB;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $baseActivities = [
            [
                'title' => 'Reunión de equipo',
                'description' => 'Reunión semanal con el equipo de desarrollo',
                'color' => '#4da6ff',
                'tags' => [3], // ID 3 = Trabajo
            ],
            [
                'title' => 'Llamada con cliente',
                'description' => 'Presentación del avance del proyecto',
                'color' => '#ff9933',
                'tags' => [3, 4], // ID 3 = Trabajo, ID 4 = Urgente
            ],
            [
                'title' => 'Enviar informe',
                'description' => 'Preparar y enviar informe mensual',
                'color' => '#ff4d4d',
                'tags' => [1], // ID 1 = Importante
            ],
        ];

        $activityTagEntries = [];

        foreach ($baseActivities as $activity) {
            $activityId = DB::table('activities')->insertGetId([
                'title' => $activity['title'],
                'description' => $activity['description'],
                'color' => $activity['color'],
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insertar las relaciones con las etiquetas predefinidas
            foreach ($activity['tags'] as $tagId) {
                $activityTagEntries[] = [
                    'activity_id' => $activityId,
                    'tag_id' => $tagId,
                ];
            }
        }

        if (!empty($activityTagEntries)) {
            DB::table('activity_tag')->insert($activityTagEntries);
        }

        // Crear entradas del diario con colores predeterminados
        DefaultDiaryColorsSeeder::createDefaultEntriesForUser($user->id);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
