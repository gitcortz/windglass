<?php

use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\OrderStatus::create([
            'name' => 'pending'
        ]);

        \App\OrderStatus::create([
            'name' => 'completed' 
        ]);

        \App\OrderStatus::create([
            'name' => 'void'
        ]);
    }
}
