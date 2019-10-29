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
        \App\PaymentStatus::create([
            'name' => 'unpaid', 
        ]);

        \App\PaymentStatus::create([
            'name' => 'paid', 
        ]);
    }
}
