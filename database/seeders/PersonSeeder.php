<?php

namespace Database\Seeders;

use App\Models\Person\Person;
//use Database\Factories\Person\PersonFactory;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Person::factory()->count(50)->create();
    }
}
