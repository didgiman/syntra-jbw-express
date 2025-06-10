<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();

        $this->call(TypeSeeder::class);
        $this->call(EventSeeder::class);
        $this->call(AttendeeSeeder::class);
        $this->call(TestingSeeder::class);
    }
}
