<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSupervisorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supervisions = [
            14758,
            15323,
            14039,
            16679,
            85128,
            13686,
            51575
        ];
        foreach($supervisions as $supervision){
            DB::table('employee_supervisors')->insert([
                'staff_no'=> $supervision,
                'supervisor_staff_no'=> 14041
            ]);
        }
    }
}
