<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class KPI extends Model
{
    use SoftDeletes;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $guarded = [];

    // kpi period
    public function getPeriod()
    {
        /* $today = new \DateTime();
        $today->setDate(date('Y'), 9, 1);

        $year = (int) $today->format('Y');
        $week = (int) $today->format('w'); // Week of the year
        $day = (int) $today->format('d'); // Day of the week (0 = sunday)

        $sameDayLastYear = new \DateTime();
        $sameDayLastYear->setISODate($year - 1, $week, $day);

        return $sameDayLastYear->format('Y-m-d') . PHP_EOL . " To " . $today->format('Y-m-d') . PHP_EOL;
 */
        $year = date('Y');
        $month = 6;
        $day = 1;
        $current_date = date($year."-".$month."-".$day);
        $strtotime = strtotime($current_date);
        $last_year = strtotime("-1 year", $strtotime);
        echo date("Y-m-d", $last_year);
        echo " To " . $current_date;
    }

    // kpi codes
    public function getNewCode()
    {

        $last = DB::table('k_p_i_s')->latest()->first();

        if ($last) {
            // increament code
            $code = explode('i', $last->code);
            $val   = $code[1] + 1;
            // new code
            return 'kpi' . str_pad($val, 3, "0", STR_PAD_LEFT);
        } else {
            // create new code
            return 'kpi' . str_pad(1, 3, "0", STR_PAD_LEFT);
        }
    }

    // kpi tasks relationship
    public function tasks()
    {
        return $this->hasMany(Task::class, 'description', 'code');
    }


    //achievement
    public function achievement($id)
    {
        // $task = KPI::where('code', $id)->first();
        // if ($task->kpi_type == 'NotTasked') {
        //     return 2.40;
        // }
        // dd('here');
        // get number of hours
        $numberOfHours = DB::table('tasks')
            ->where('responsible', Auth::user()->staff_no)
            ->where('description', $id)
            // ->whereNotNull('created_date')
            // ->whereBetween('resolution_date', [$start, $end])
            ->select(DB::raw("SUM(time_to_sec(timediff(resolution_date, created_date)) / 3600) as result"))
            ->get(['result']);

        $numberOfTasks = DB::table('tasks')
            ->where('responsible', Auth::user()->staff_no)
            ->where('description', $id)
            // ->whereNull('deleted_at')
            ->count();

        // sum all the hours
        $totalHours = 0.00;
        foreach ($numberOfHours as $key => $hour) {
            $totalHours += $hour->result;
        }

        // return dd($numberOfHours);

        // get achievement
        if (($numberOfTasks > 0) && ($totalHours > 0)) {
            return number_format(($totalHours / $numberOfTasks), 2);
        } else {
            return 0.00;
        }
    }

    // sum the weight
    public function totalWeight()
    {
        $sumWeight = DB::table('k_p_i_s')
            ->where('group_id', Auth::user()->group_id)
            // ->where('description', $id)
            ->whereNull('deleted_at')
            ->sum('weight');

        return number_format($sumWeight, 2);
    }
    // raw score
    public function rawScore($T, $Xa, $kpi_type = 'Tasked')
    {
        if ($kpi_type == 'Not Tasked') {
            return 2.40;
        }
        //  T <= 0
        if ($T <= 0) {
            return  $this->zeroT($Xa);
        } elseif (((2 * $T) - $Xa) > 0) {
            // inc achievement
            return $this->increasingAchievement($T, $Xa);
        } else {
            // dd('here');

            // dec achievement
            return $this->decreasingAchievement($T, $Xa);
        }
    }
    // weighted score
    public function weightedScore($T, $Xa, $W, $kpi_type ='Tasked')
    {
        if ($kpi_type === "Not Tasked") {
         $ws = $this->rawScore($T, $Xa, $kpi_type) / 100;
        }else{
            $ws = ($this->rawScore($T, $Xa, $kpi_type) * $W) / 100;
        }

        return $ws;
    }

    // sum weighted score
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
        // if($ach)
        // $rs = (1.00 + 4.00) * (((2 * $t) - $ach) / (2 * $t));
        $rs = (1.00) + (4.00 * ((2 * $t) - $ach) / (2 * $t));
        // if ($rs > 5.00) {
        //     $rs = 5.00;
        // } elseif ($rs  < 1.00) {
        //     $rs = 1.00;
        // }
        return $rs;
    }

    // decreasing achievement is desirable
    public  function decreasingAchievement($t, $ach)
    {
        $rs = 1.00 + ((2 * $ach) / $t);

        // if ($rs > 5.00) {
        //     $rs = 5.00;
        // } elseif ($rs  < 1.00) {
        //     $rs = 1.00;
        // }
        return $rs;
    }

    // get the raw
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
                return  $value.' Is Out Of Range > 1 and < 5';
                break;
        }
        return  $grade;
    }
}
