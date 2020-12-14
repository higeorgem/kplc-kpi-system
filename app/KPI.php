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
}
