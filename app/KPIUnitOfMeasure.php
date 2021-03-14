<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KPIUnitOfMeasure extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kpi_id',
        'created_by',
        'unit_of_measure'
    ];

    
}
