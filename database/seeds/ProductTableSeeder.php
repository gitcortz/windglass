<?php

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Product::create([
            'name' => 'Shellane', 
            'type' => 'gas_tank',
            'price' => 200.00           
        ]);

        \App\Product::create([
            'name' => 'Gasul',
            'type' => 'gas_tank',  
            'price' => 201.00           
        ]);
    }
}
