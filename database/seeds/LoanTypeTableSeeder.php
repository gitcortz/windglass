<?php

use Illuminate\Database\Seeder;

class LoanTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            \App\LoanType::create([
                'name' => 'sss', 
                'month_term' => 12, 
                'fixed_amount' => 0,                
            ]);

            \App\LoanType::create([
                'name' => 'salary', 
                'month_term' => 0, 
                'fixed_amount' => 500,                
            ]);

            \App\LoanType::create([
                'name' => 'vale', 
                'month_term' => 0, 
                'fixed_amount' => 0,                
            ]);
        
    }
}
