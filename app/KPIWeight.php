<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KPIWeight extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kpi_id',
        'weight',
        'created_by',
    ];
}
