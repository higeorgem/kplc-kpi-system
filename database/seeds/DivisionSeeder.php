<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $division_names = [
            'MD & CEO', 'Corporate Affairs & Company Sec.', 'Network Management', 'Infrastructure Development',
            'HR & Administration', 'Finance', 'ICT', 'Supply Chain', 'Customer Service', 'Business Strategy',
            'Regional Operations', 'Internal Audit'
        ];
        foreach ($division_names as $key => $name) {
            DB::table('divisions')->insert([
                'name' => $name
            ]);
        }
    }
}
