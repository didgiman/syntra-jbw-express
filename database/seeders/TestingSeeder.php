<?php

namespace Database\Seeders;

use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestingSeeder extends Seeder
{
    protected static ?string $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = [];
        $user = [
            [
                'name' => 'Admin User',
                'email' => 'admin@eventr.be',
                'email_verified_at' => now(),
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Testevent Creator',
                'email' => 'testevent@example.be',
                'email_verified_at' => now(),
                'password' => static::$password ??= Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        DB::table('users')->insert($user);

        $types = Type::all();
        $events = [];
        $events = [
            [
                'user_id' => DB::table('users')->latest('id')->first()->id,
                'name' => 'begin verleden, eind toekomst',
                'description' => fake()->text,
                'start_time' => Carbon::create(2025, 6, 6, 11, 45, 0),
                'end_time' => Carbon::create(2025, 7, 6, 11, 45, 0),
                'location' => fake()->city(),
                'type_id' => $types->random()->id,
                'max_attendees' => null,
                'price' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => DB::table('users')->latest('id')->first()->id,
                'name' => 'past event',
                'description' => fake()->text,
                'start_time' => Carbon::create(2025, 6, 6, 11, 45, 0),
                'end_time' => Carbon::create(2025, 6, 7, 11, 45, 0),
                'location' => fake()->city(),
                'type_id' => $types->random()->id,
                'max_attendees' => null,
                'price' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => DB::table('users')->latest('id')->first()->id,
                'name' => 'full attendance',
                'description' => fake()->text,
                'start_time' => Carbon::create(2025, 7, 6, 11, 45, 0),
                'end_time' => Carbon::create(2025, 7, 7, 11, 45, 0),
                'location' => fake()->city(),
                'type_id' => $types->random()->id,
                'max_attendees' => 5,
                'price' => 49.99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'user_id' => DB::table('users')->latest('id')->first()->id,
                'name' => 'deels attendance',
                'description' => fake()->text,
                'start_time' => Carbon::create(2025, 7, 15, 11, 45, 0),
                'end_time' => Carbon::create(2025, 7, 18, 11, 45, 0),
                'location' => fake()->city(),
                'type_id' => $types->random()->id,
                'max_attendees' => 5,
                'price' => 99.99,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        DB::table('events')->insert($events);

        $attendees = [];
        for ($i = 1; $i <= 5; $i++) {
            $attendees[] = [
                'user_id' => $i,
                'event_id' => DB::table('events')->orderBy('id')->skip(DB::table('events')->count() - 2)->first()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        for ($i = 1; $i <= 3; $i++) {
            $attendees[] = [
                'user_id' => $i,
                'event_id' => DB::table('events')->latest('id')->first()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        DB::table('attendees')->insert($attendees);
    }
}
