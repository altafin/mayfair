<?php

namespace Database\Seeders;

use App\Models\Person\AddressType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrTypes = array(
            array(
                'name' => 'HOME',
                'system' => true,
            ),
            array(
                'name' => 'WORK',
                'system' => true,
            ),
        );
        foreach ($arrTypes as $types) {
            AddressType::factory()->create($types);
        }

    }
}
