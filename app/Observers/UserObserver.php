<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Tag;
use Database\Seeders\DefaultDiaryColorsSeeder;
use Illuminate\Support\Facades\DB;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        DB::transaction(function () use ($user) {
            // Primero crear los tags por defecto
            $defaultTags = [
                ['name' => 'Importante', 'color' => '#ff4d4d'],
                ['name' => 'Personal', 'color' => '#4da6ff'],
                ['name' => 'Trabajo', 'color' => '#66cc66'],
                ['name' => 'Urgente', 'color' => '#ff9933'],
                ['name' => 'Recordatorio', 'color' => '#cc99ff']
            ];

            $tagIds = [];
            
            // Verificar si ya existen tags para este usuario
            $existingTags = Tag::where('user_id', $user->id)->get();
            if ($existingTags->isEmpty()) {
                foreach ($defaultTags as $tag) {
                    $tagIds[$tag['name']] = DB::table('tags')->insertGetId([
                        'name' => $tag['name'],
                        'color' => $tag['color'],
                        'user_id' => $user->id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }

                // Luego crear las actividades base
                $baseActivities = [
                    [
                        'title' => 'Reunión de equipo',
                        'description' => 'Reunión semanal con el equipo de desarrollo',
                        'color' => '#4da6ff',
                        'tags' => ['Trabajo'],
                    ],
                    [
                        'title' => 'Llamada con cliente',
                        'description' => 'Presentación del avance del proyecto',
                        'color' => '#ff9933',
                        'tags' => ['Trabajo', 'Urgente'],
                    ],
                    [
                        'title' => 'Enviar informe',
                        'description' => 'Preparar y enviar informe mensual',
                        'color' => '#ff4d4d',
                        'tags' => ['Importante'],
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

                    foreach ($activity['tags'] as $tagName) {
                        $activityTagEntries[] = [
                            'activity_id' => $activityId,
                            'tag_id' => $tagIds[$tagName],
                        ];
                    }
                }

                if (!empty($activityTagEntries)) {
                    DB::table('activity_tag')->insert($activityTagEntries);
                }
            }

            // Crear plantillas de diario por defecto
            $defaultColors = DefaultDiaryColorsSeeder::$defaultColors;
            $existingTemplates = DB::table('diary_entries')
                ->where('user_id', $user->id)
                ->where('is_template', true)
                ->count();

            if ($existingTemplates === 0) {
                foreach ($defaultColors as $color) {
                    DB::table('diary_entries')->insert([
                        'user_id' => $user->id,
                        'title' => "Plantilla {$color['name']}",
                        'content' => "Esta es una plantilla con el color {$color['name']}.\n\n" .
                                   "Características:\n" .
                                   "- Color de fondo: {$color['value']}\n" .
                                   "- Color de texto: {$color['textColor']}\n\n" .
                                   "Puedes usar esta plantilla como base para tus entradas del diario.",
                        'color' => $color['value'],
                        'text_color' => $color['textColor'],
                        'is_template' => true,
                        'entry_date' => now(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        });
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
