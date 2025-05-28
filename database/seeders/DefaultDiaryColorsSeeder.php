<?php

namespace Database\Seeders;

use App\Models\DiaryEntry;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultDiaryColorsSeeder extends Seeder
{
    public static array $defaultColors = [
        ['name' => 'Lavanda', 'value' => '#E6E6FA', 'textColor' => '#4B0082'],
        ['name' => 'Menta', 'value' => '#F5FFFA', 'textColor' => '#2E8B57'],
        ['name' => 'Durazno', 'value' => '#FFDAB9', 'textColor' => '#8B4513'],
        ['name' => 'Cielo', 'value' => '#F0F8FF', 'textColor' => '#4682B4'],
        ['name' => 'Rosa', 'value' => '#FFF0F5', 'textColor' => '#C71585']
    ];

    public static function createDefaultEntriesForUser(int $userId): void
    {
        foreach (self::$defaultColors as $color) {
            DiaryEntry::create([
                'user_id' => $userId,
                'title' => "Plantilla {$color['name']}",
                'content' => "Esta es una plantilla con el color {$color['name']}",
                'color' => $color['value'],
                'entry_date' => Carbon::now()
            ]);
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Este método se deja vacío ya que las entradas se crearán a través del observer
    }
}
