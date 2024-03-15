<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrStates = array(
            'cities-parana.txt' => 18,
            'cities-santa_catarina.txt' => 24
        );
        foreach ($arrStates as $stateFile => $id) {
            $content = fopen(Storage::path($stateFile), 'r');
            while (!feof($content)) {
                $line = fgets($content);
                if (!empty($line)) {
                    $arrCity = array(
                        'name' => $line,
                        'state_id' => $id,
                    );
                    City::factory()->create($arrCity);
                }
            }
            fclose($content);
        }
    }
}
