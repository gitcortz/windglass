<?php

use Illuminate\Database\Seeder;

class EmployeeLoanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\EmployeeLoan::create([
            'loan_amount' => 10000, 
            'status' => 0, 
            'employee_id' => 1, 
            'loan_type_id' => 1             
        ]);

        \App\EmployeeLoan::create([
            'loan_amount' => 100, 
            'status' => 0, 
            'employee_id' => 1, 
            'loan_type_id' => 3            
        ]);

        \App\EmployeeLoan::create([
            'loan_amount' => 2000, 
            'status' => 0, 
            'employee_id' => 2, 
            'loan_type_id' => 2            
        ]);

        \App\EmployeeLoan::create([
            'loan_amount' => 300, 
            'status' => 0, 
            'employee_id' => 3, 
            'loan_type_id' => 3            
        ]);
    }
}
