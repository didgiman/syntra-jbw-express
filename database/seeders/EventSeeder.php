<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $types = Type::all();

        for ($i = 0; $i < 10; $i++) {
            $user = $users->random();
            $type = $types->random();

            Event::factory()->create([
                'user_id' => $user->id,
                'type_id' => $type->id
            ]);
        }
    }
}
