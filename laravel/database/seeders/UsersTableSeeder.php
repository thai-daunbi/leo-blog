<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'leo',
                'city_id' => 1,
                'email' => 'leo@mail.com',
            ],
            [
                'id' => 2,
                'name' => 'john',
                'city_id' => 2,
                'email' => 'john@mail.com',
            ],
            [
                'id' => 3,
                'name' => 'lisa',
                'city_id' => 3,
                'email' => 'lisa@mail.com',
            ],
            
        ]);
    }
}
