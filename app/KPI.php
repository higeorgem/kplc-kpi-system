<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KPI extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function getNewCode(){

        $last = DB::table('k_p_i_s')->latest()->first();

        if ($last) {
            // increament code
            $code = explode('i',$last->code);
            $val   = $code[1] + 1;
            // new code
           return 'kpi'.str_pad($val, 3, "0", STR_PAD_LEFT);
        }else{
            // create new code
            return 'kpi' . str_pad(1, 3, "0", STR_PAD_LEFT);
        }
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'description', 'code');
    }
    // raw score
    public function rawScore($T, $Xa)
    {
        //  T <= 0
        if ($T <= 0) {
          return  $this->zeroT($Xa);
        }elseif (((2*$T)-$Xa) > 0) {
        // inc achievement
            return $this->increasingAchievement($T, $Xa);
        }else {
            // dec achievement
            return $this->decreasingAchievement($T, $Xa);
        }

    }
    // weighted score
    public function weightedScore($T, $Xa , $W)
    {
        $ws = ($this->rawScore($T, $Xa) * $W)/100;
        return $ws;
    }

    public function sumWeightedScore($value)
    {
        $sum = 0;
        return $sum += $value;
    }
    // t is zero.
    public function zeroT($ach)
    {
        // actual achievement is zero, the raw score is automatically 2.40.
        if ($ach <= 0) {
            return 2.40;
        } else {
            // incident recorded, the raw score is automatically 5.00,
            return 5.0;
        }
    }

    // increasing achievement is desirable
    public  function increasingAchievement($t, $ach)
    {
        $rs = (1.00 + 4.00) * (((2*$t) - $ach)/(2*$t));
        return $rs;
    }

    // decreasing achievement is desirable
    public  function decreasingAchievement($t, $ach)
    {
        $rs = 1.00 + ((2*$ach)/$t);
        return $rs;
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

        return $value . ' ' . $grade;
    }
}
