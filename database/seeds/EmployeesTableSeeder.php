<?php

use Illuminate\Database\Seeder;
use  App\Employee;
class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'firstname'    => 'admin',
            'lastname'    => '000',
            'email'    => 'admin@gmail.com',
            'password'   =>  Hash::make('123456'),
            'remember_token' =>  Str::random(10),
        ]);
    }
}
