<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UomSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('uoms')->insert([
            ['unit_of_measurement' => 'Strip'],
            ['unit_of_measurement' => 'Bottle'],
            ['unit_of_measurement' => 'Roll'],
            ['unit_of_measurement' => 'Pack'],
            ['unit_of_measurement' => 'Tube'],
            ['unit_of_measurement' => 'Pcs'],
            ['unit_of_measurement' => 'Set'],
            ['unit_of_measurement' => 'Box'],
            ['unit_of_measurement' => 'Bundle'],
        ]);
    }
}
