<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KPISeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kpis = [
            [
                'code'=>'kpi001',
                'perspective' => ' Customer/ Stakeholder',
                'period' =>   ' 20-21',
                'kpi' =>  'ICT User Satisfaction Index',
                'unit_of_measure'  => ' %',
                'weight' =>  10,
                'previous_target'  =>  0.79,
                'target' =>  0.8,
                'achievement'  =>  0.8,
                'validated_achievement' =>  0.8,
                'row_score' => '',
                'weighted_score' => ''
            ],
            [
                'code'=>'kpi002',
                'perspective' => ' Customer/ Stakeholder',
                'period' =>   '20-21',
                'kpi' =>  ' Resolution Time to User Requests',
                'unit_of_measure'  => 'Hrs.',
                'weight' =>  10,
                'previous_target'  =>  0.5,
                'target' =>  0.8,
                'achievement'  =>  0.8,
                'validated_achievement' =>  0.8,
                'row_score' => '',
                'weighted_score' => ''
            ],
            [
                'code'=>'kpi003',
                'perspective' => ' Customer/ Stakeholder',
                'period' =>   '20-21',
                'kpi' =>  'System development(Introduction of new modules/functions)-Unscheduled',
                'unit_of_measure'  => 'Days',
                'weight' =>  20,
                'previous_target'  =>  18,
                'target' =>  20,
                'achievement'  =>  18,
                'validated_achievement' =>  18,
                'row_score' => '',
                'weighted_score' => ''
            ],
            [
                'code'=>'kpi004',
                'perspective' => ' Customer/ Stakeholder',
                'period' =>   '20-21',
                'kpi' =>  'System improvements/modifications (fixing errors, bugs and enhancements)',
                'unit_of_measure'  => 'Days',
                'weight' =>  20,
                'previous_target'  =>  7,
                'target' =>  8,
                'achievement'  =>  7,
                'validated_achievement' =>  7,
                'row_score' => '',
                'weighted_score' => ''
            ],
            [
                'code'=>'kpi005',
                'perspective' => ' Customer/ Stakeholder',
                'period' =>   '20-21',
                'kpi' =>  ' Compliance with Systems Development and maintenance policies',
                'unit_of_measure'  => '%',
                'weight' =>  10,
                'previous_target'  =>  96,
                'target' =>  96,
                'achievement'  =>  96,
                'validated_achievement' =>  96,
                'row_score' => '',
                'weighted_score' => ''
            ],
            [
                'code'=>'kpi006',
                'perspective' => 'Organizational Capabilities',
                'period' =>   '20-21',
                'kpi' =>  'No of Innovations/business automations Successfully Implemented',
                'unit_of_measure'  => 'No',
                'weight' =>  30,
                'previous_target'  =>  1,
                'target' =>  4,
                'achievement'  =>  1,
                'validated_achievement' =>  2,
                'row_score' => '',
                'weighted_score' => ''
            ],
           
        ];
        foreach ($kpis as $key => $kpi) {
            DB::table('k_p_i_s')->insert([
                'code'=>$kpi['code'],
                'perspective' => $kpi['perspective'],
                'period'=>$kpi['period'],
                'kpi'=>$kpi['kpi'],
                'unit_of_measure'=>$kpi['unit_of_measure'],
                'weight'=>$kpi['weight'],
                'previous_target'=>$kpi['previous_target'],
                'target'=>$kpi['target'],
                'achievement'=>$kpi['achievement'],
                'validated_achievement'=>$kpi['validated_achievement'],
                'row_score'=>$kpi['row_score'],
               'weighted_score'=>$kpi['weighted_score'],
            ]);
        }
    }
}
