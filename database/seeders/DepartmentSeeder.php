<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('order')->insert([
            ['department' => 'Compliance'],
            ['department' => 'Sewing'],
            ['department' => 'Packing'],
            ['department' => 'Cutting'],
            ['department' => 'Warehouse'],
        ]);
    }
    
}
