<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [];
        $types = [
            [
                'description' => 'Charity',
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'Concert',
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'Fair',
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'Festival',
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'Online Event',
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'Sport Event',
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'Workshop',
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'description' => 'Other',
                'color' => sprintf('#%06X', mt_rand(0, 0xFFFFFF)),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        DB::table('types')->insert($types);
    }
}
