<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

     public function run(): void
     {
         DB::table('items')->insert([
            ['item_code' => '20220421080656',
            'description' => 'Panadol Flu dan Batuk',
            'unit_of_measurement_id' => '1',],

            ['item_code' => '20220421084254', 
            'description' => 'Panadol Paracetamol',
            'unit_of_measurement_id' => '1',],

            ['item_code' => '20220421084431',
            'description' => 'Betadine 15ml',
            'unit_of_measurement_id' => '2',],

            ['item_code' => '20220421084517',
            'description' => 'Elastic Bandage 10cm x 4.5m',
            'unit_of_measurement_id' => '3',], 

            ['item_code' => '20220421084549',
            'description' => 'Feminax',
            'unit_of_measurement_id' => '1',],

            ['item_code' =>  '20220421084659',
            'description' => 'Plester Rol Kain 1.25cm x 5m',
            'unit_of_measurement_id' => '3',],

            ['item_code' => '20220421084735',
            'description' => 'Cotton Bud',
            'unit_of_measurement_id' => '4',],
            
            ['item_code' => '20220421084735',
            'description' => 'Kapas Putih 25g',
            'unit_of_measurement_id' => '4',],

            ['item_code' => '20220421084843',
            'description' => 'Sterillised Water 25ml',
            'unit_of_measurement_id' =>  '5',],

            // ['item_code' => 
            // 'description' => 
            // 'unit_of_measurement_id' => ],
 
         ]);

         DB::table('stocks')->insert([
            ['qty' => '16',
            'item_id' => '1',],

            ['qty' =>  '7',
            'item_id' =>  '2',],

            ['qty' =>  '10',
            'item_id' => '3', ],

            ['qty' =>  '5',
            'item_id' => '4',],

            ['qty' => '59',
            'item_id' => '5',],

            ['qty' => '17',
            'item_id' => '6',],

            ['qty' =>  '6',
            'item_id' => '7',],

            ['qty' => '11',
            'item_id' => '8',],
            
            ['qty' => '17',
            'item_id' => '9',],
            // ,    
            // ,      
         ]);
     }
}
