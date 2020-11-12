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
        // $this->call(UserSeeder::class);
        $this->call(DivisionSeeder::class);
        $this->call(KPISeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(EmployeeSupervisorSeeder::class);

    }
}
