<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content = fopen(Storage::path('states.txt'), 'r');
        while (!feof($content)) {
            $line = fgets($content);
            if (!empty($line)) {
                list($id, $name, $abbreviation, $region_id) = explode(';', $line);
                $arrState = array(
                    'id' => $id,
                    'name' => trim($name),
                    'abbreviation' => $abbreviation,
                    'region_id' => $region_id,
                );
                State::factory()->create($arrState);
            }
        }
        fclose($content);
    }
}
