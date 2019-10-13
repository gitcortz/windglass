<?php

use Illuminate\Database\Seeder;

class TimesheetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 14; $j++) {
                $time_in = new DateTime(date("Y-m-d", strtotime("-".$j." day")));
                $time_out = new DateTime(date("Y-m-d", strtotime("-".$j." day")));
                $time_in->setTime(8, 00, 00);
                $time_out->setTime(17+$i, 00, 00);
                \App\Timesheet::create([
                    'time_in' => $time_in, 
                    'time_out' => $time_out, 
                    'employee_id' => $i+1
                ]);
               
            }
        }
    }
}
