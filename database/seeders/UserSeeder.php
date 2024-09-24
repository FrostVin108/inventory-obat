<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('User')->insert([
            ['name' => 'Admin'],
            ['email' => 'AdminGhimli@gmail.com'],
            ['password' => Hash::make('Ghimli@2025')],
        ]);
    }
}
