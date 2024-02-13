<?php

namespace Database\Seeders;

use App\Models\Person\Person;
use Illuminate\Database\Seeder;

class PersonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Person::factory()
            ->count(20)
            ->hasDocuments(1, function (array $attributes, Person $person) {
                return [
                    'document_type_id' => ($person->type === 'F' ? 1 : 2),
                    'value' => ($person->type === 'F' ? $attributes['value'] : $attributes['value']. '000'),
                ];
            })
            ->hasCategories(1)
            ->create();
    }
}
