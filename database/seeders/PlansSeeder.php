<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('plans')->delete();
        DB::table('plans')->insert([
            [
                'name' => '2 Sessions a week - One month',
                'price' => 49,
                'type' => 'WEEKLY_2',
                'count_sessions' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '3 Sessions a week - One month',
                'price' => 60,
                'type' => 'WEEKLY_3',
                'count_sessions' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '4 Sessions a week - One month',
                'price' => 76,
                'type' => 'WEEKLY_4',
                'count_sessions' => 16,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '5 Sessions a week - One month',
                'price' => 90,
                'type' => 'WEEKLY_5',
                'count_sessions' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
