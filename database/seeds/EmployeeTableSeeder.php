<?php

use Illuminate\Database\Seeder;

class EmployeeTableSeeder extends Seeder
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
            \App\Employee::create([
                'first_name' => $faker->firstName, 
                'last_name' => $faker->lastName, 
                'address' => $faker->address,
                'city' => $faker->city,
                'phone' => $faker->e164PhoneNumber,
                'mobile' => $faker->e164PhoneNumber,
                'salary' => 500,
                'hire_date' => $faker->dateTime($max = 'now', $timezone = null),
            ]);
        }
    }
}
