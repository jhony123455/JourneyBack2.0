<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['id' => 1, 'name' => 'Importante', 'color' => '#ff4d4d', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Personal', 'color' => '#4da6ff', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Trabajo', 'color' => '#66cc66', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Urgente', 'color' => '#ff9933', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Recordatorio', 'color' => '#cc99ff', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('tags')->insert($tags);
    }
}
