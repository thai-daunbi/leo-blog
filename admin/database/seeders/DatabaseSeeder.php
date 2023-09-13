<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('schedules')->insert([
            'title' => 'Example Event 1',
            'start' => now(),
            'end' => now()->addHours(2),
            'button1' => '0',
            'button2' => '0',
            'button3' => '0',
            'button4' => '0',
            'button5' => '0',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
