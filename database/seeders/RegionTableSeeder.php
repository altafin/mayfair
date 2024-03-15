<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content = fopen(Storage::path('regions.txt'), 'r');
        while (!feof($content)) {
            $line = fgets($content);
            if (!empty($line)) {
                list($id, $name) = explode(';', $line);
                $arrRegion = array(
                    'id' => $id,
                    'name' => $name,
                );
                Region::factory()->create($arrRegion);
            }
        }
        fclose($content);
    }
}
