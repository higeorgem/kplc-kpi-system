<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Report extends Model
{
    public $target;
    public $actual_achievement;

    public function __construct($target = 0, $actual_achievement = 0)
    {
        $this->target = $target;
        $this->actual_achievement = $actual_achievement;
    }
    // target is zero.
    public function zeroTarget($target, $actual_achievement)
    {
        // actual achievement is zero, the raw score is automatically 2.40.
        if($actual_achievement <= 0){
            return 2.40;
        }else{
        // incident recorded, the raw score is automatically 5.00,
            return 5.0;
        }
    }

    // check achievement
    public function processReport($target, $actual_achievement)
    {
        // Target <= 0
        if ($target <= 0) {
          return  $this->zeroTarget($target, $actual_achievement);
        }elseif (((2*$target)-$actual_achievement) > 0) {
        // inc achievement
            return $this->increasingAchievement($target, $actual_achievement);
        }else {
            // dec achievement
            return $this->decreasingAchievement($target, $actual_achievement);
        }

    }

    // increasing achievement is desirable
    public  function increasingAchievement($target, $actual_achievement)
    {

    }

    // decreasing achievement is desirable
    public  function decreasingAchievement($target, $actual_achievement)
    {

    }
    // target is a date.
    public  function targetDate($target, $actual_achievement)
    {
        //step : 1  target and actual in days
        // a target done monthly has a maximum period of 30 days while an annual targets
        // has a maximum of 365 days.

        // step : 2 Count the number of target days and actual days
        /**
         * a target of completing a task by 30th September equals 92 days. If
         *   the target is achieved on 12th September, then the actual
         *   achievement is 74 days. Further, a target supposed to be done by
         *   the 10th day of the month has a maximum of 10 days. If it is done on
         *   12th day of the month, the achievement is 12.
         */
    }

    public function grade($value)
    {
        $grade = '';

        switch ($value) {
            case ($value >= 1 && $value <= 2.40):
                $grade = 'Excellent';
                break;
            case ($value >= 2.40 && $value <= 3.00):
                $grade = 'Very Good';
                break;
            case ($value >= 3.00 && $value <= 3.60):
                $grade = 'Good';
                break;
            case ($value >= 3.60 && $value <= 4.00):
                $grade = 'Fair';
                break;
            case ($value >= 4.00 && $value <= 5.00):
                $grade = 'Poor';
                break;
            default:
                return 'Out Of Range';
                break;
        }

        return $value.' '.$grade;
    }
}
