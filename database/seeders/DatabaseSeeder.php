<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            DocumentTypesTableSeeder::class,
            AddressTypesTableSeeder::class,
            ContactTypesTableSeeder::class,
        ]);
        $this->command->info('User table seeded!');
        $this->command->info('Document types seeded!');
        $this->command->info('Address types seeded!');
        $this->command->info('Contact types seeded!');

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
