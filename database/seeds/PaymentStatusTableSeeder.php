<?php

use Illuminate\Database\Seeder;

class PaymentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\PaymentMethod::create([
            'name' => 'unpaid', 
        ]);

        \App\PaymentMethod::create([
            'name' => 'paid', 
        ]);
    }
}
