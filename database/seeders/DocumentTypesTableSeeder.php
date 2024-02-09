<?php

namespace Database\Seeders;

use App\Models\Person\DocumentType;
use Illuminate\Database\Seeder;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DocumentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrTypes = array(
            array(
                'name' => 'CPF',
                'system' => true,
            ),
            array(
                'name' => 'CNPJ',
                'system' => true,
            ),
        );
        foreach ($arrTypes as $types) {
            DocumentType::factory()->create($types);
        }
    }
}
