<?php

namespace Database\Seeders;

use App\Models\DocumentType;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
