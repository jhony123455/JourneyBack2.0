<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = User::first()->id ?? 1;

        // Crear fechas para las actividades
        $now = Carbon::now();
        $startTime1 = $now->copy()->addHours(1);
        $endTime1 = $startTime1->copy()->addHours(2);

        $startTime2 = $now->copy()->addHours(3);
        $endTime2 = $startTime2->copy()->addHours(1);

        $startTime3 = $now->copy()->addDays(1);
        $endTime3 = $startTime3->copy()->addHours(3);

        $activities = [
            [
                'id' => 1,
                'title' => 'Reunión de equipo',
                'description' => 'Reunión semanal con el equipo de desarrollo',
                'color' => '#4da6ff',
                'start_time' => $startTime1,
                'end_time' => $endTime1,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'title' => 'Llamada con cliente',
                'description' => 'Presentación del avance del proyecto',
                'color' => '#ff9933',
                'start_time' => $startTime2,
                'end_time' => $endTime2,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'title' => 'Enviar informe',
                'description' => 'Preparar y enviar informe mensual',
                'color' => '#ff4d4d',
                'start_time' => $startTime3,
                'end_time' => $endTime3,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('activities')->insert($activities);
        $activityTags = [
            ['activity_id' => 1, 'tag_id' => 3], // Reunión de equipo - Trabajo
            ['activity_id' => 2, 'tag_id' => 3], // Llamada con cliente - Trabajo
            ['activity_id' => 2, 'tag_id' => 4], // Llamada con cliente - Urgente
            ['activity_id' => 3, 'tag_id' => 1], // Enviar informe - Importante
        ];

        DB::table('activity_tag')->insert($activityTags);
    }
}
