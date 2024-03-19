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
            'cities-acre.txt' => 1,
            'cities-alagoas.txt' => 2,
            'cities-amazonas.txt' => 3,
            'cities-amapa.txt' => 4,
            'cities-bahia.txt' => 5,
            'cities-ceara.txt' => 6,
            'cities-distrito_federal.txt' => 7,
            'cities-espirito_santo.txt' => 8,
            'cities-goias.txt' => 9,
            'cities-maranhao.txt' => 10,
            'cities-minas_gerais.txt' => 11,
            'cities-mato_grosso_do_sul.txt' => 12,
            'cities-mato_grosso.txt' => 13,
            'cities-para.txt' => 14,
            'cities-paraiba.txt' => 15,
            'cities-pernambuco.txt' => 16,
            'cities-piaui.txt' => 17,
            'cities-parana.txt' => 18,
            'cities-rio_de_janeiro.txt' => 19,
            'cities-rio_grande_do_norte.txt' => 20,
            'cities-rondonia.txt' => 21,
            'cities-roraima.txt' => 22,
            'cities-rio_grande_do_sul.txt' => 23,
            'cities-santa_catarina.txt' => 24,
            'cities-sergipe.txt' => 25,
            'cities-sao_paulo.txt' => 26,
            'cities-tocantins.txt' => 27
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
