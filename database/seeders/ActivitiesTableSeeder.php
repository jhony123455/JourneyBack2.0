<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        // Definimos las actividades base con los IDs fijos de las etiquetas predefinidas
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

        // Verificar que existan las etiquetas globales predefinidas
        $existingTagIds = DB::table('tags')->pluck('id')->toArray();
        $allNeededTags = [];
        foreach ($baseActivities as $activity) {
            foreach ($activity['tags'] as $tagId) {
                $allNeededTags[$tagId] = true;
            }
        }
        
        // Validar que todas las etiquetas necesarias existen
        foreach (array_keys($allNeededTags) as $tagId) {
            if (!in_array($tagId, $existingTagIds)) {
                throw new \Exception("La etiqueta con ID {$tagId} no existe en la base de datos");
            }
        }
        
        // Ahora crear las actividades para cada usuario con las etiquetas predefinidas
        foreach ($users as $user) {
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
        }
    }
}