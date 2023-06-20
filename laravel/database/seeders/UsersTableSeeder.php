<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => '$2y$10$pmqRjJSevECzV0BTdzeLxetc4eClaw/EYG1Q0GD0apuG5szm28RP6' //aaaa1111
        ]);
        User::factory()->times(3)->create();
    }
}
