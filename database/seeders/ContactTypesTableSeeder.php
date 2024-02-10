<?php

namespace Database\Seeders;

use App\Models\Person\ContactType;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrTypes = array(
            array(
                'name' => 'EMAIL',
                'system' => true,
            ),
            array(
                'name' => 'PHONE',
                'system' => true,
            ),
            array(
                'name' => 'CELL',
                'system' => true,
            ),
            array(
                'name' => 'WEBSITE',
                'system' => true,
            ),
        );
        foreach ($arrTypes as $types) {
            ContactType::factory()->create($types);
        }
    }
}
