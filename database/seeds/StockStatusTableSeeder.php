<?php

use Illuminate\Database\Seeder;

class StockStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\StockStatus::create([
            'name' => 'normal', 
        ]);


    }
}
