<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener el primer usuario o crear uno si no existe
        $user = User::first() ?? User::factory()->create();

        $tags = [
            ['id' => 1, 'name' => 'Importante', 'color' => '#ff4d4d', 'user_id' => $user->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Personal', 'color' => '#4da6ff', 'user_id' => $user->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Trabajo', 'color' => '#66cc66', 'user_id' => $user->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Urgente', 'color' => '#ff9933', 'user_id' => $user->id, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Recordatorio', 'color' => '#cc99ff', 'user_id' => $user->id, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('tags')->insert($tags);
    }
}
