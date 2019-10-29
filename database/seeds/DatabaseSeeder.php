<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomerTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(EmployeeTableSeeder::class);
        $this->call(LoanTypeTableSeeder::class);
        $this->call(EmployeeLoanTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(PaymentStatusTableSeeder::class);
        $this->call(PaymentMethodTableSeeder::class);
        $this->call(StoreTableSeeder::class);
        $this->call(TimesheetTableSeeder::class);
        $this->call(ProductTableSeeder::class);
    }
}
